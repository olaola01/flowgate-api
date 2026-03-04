<?php

namespace App\Services\Flowgate;

use App\Data\Flowgate\ApiKeySecretData;
use App\Models\Flowgate\ApiKey;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

/**
 * Handles API key generation, rotation, and verification.
 */
class ApiKeyService
{
    /**
     * Create a new service instance.
     */
    public function __construct(private readonly FlowgateLogger $logger) {}

    /**
     * Create and persist a new API key for a project.
     */
    public function createKey(int $projectId, ?int $policyId, string $name, ?string $expiresAt = null): ApiKeySecretData
    {
        $plain = 'fg_live_'.Str::random(48);
        $prefix = substr($plain, 0, 16);

        $apiKey = ApiKey::query()->create([
            'project_id' => $projectId,
            'rate_limit_policy_id' => $policyId,
            'name' => $name,
            'key_prefix' => $prefix,
            'key_hash' => hash('sha256', $plain),
            'status' => 'active',
            'expires_at' => $expiresAt ? CarbonImmutable::parse($expiresAt) : null,
        ]);

        $this->logger->info('api_key.created', [
            'api_key_id' => $apiKey->id,
            'project_id' => $projectId,
            'policy_id' => $policyId,
        ]);

        return new ApiKeySecretData($apiKey, $plain);
    }

    /**
     * Rotate an existing API key and return the new secret.
     */
    public function rotateKey(ApiKey $apiKey): ApiKeySecretData
    {
        $plain = 'fg_live_'.Str::random(48);
        $prefix = substr($plain, 0, 16);

        $apiKey->forceFill([
            'key_prefix' => $prefix,
            'key_hash' => hash('sha256', $plain),
            'status' => 'active',
            'revoked_at' => null,
        ])->save();

        $this->logger->info('api_key.rotated', [
            'api_key_id' => $apiKey->id,
            'project_id' => $apiKey->project_id,
        ]);

        return new ApiKeySecretData($apiKey->fresh(), $plain);
    }

    /**
     * Resolve an active API key for a token and project.
     */
    public function resolveActiveKey(string $token, int $projectId): ?ApiKey
    {
        $prefix = substr($token, 0, 16);
        $hash = hash('sha256', $token);

        $candidates = ApiKey::query()
            ->where('project_id', $projectId)
            ->where('key_prefix', $prefix)
            ->where('status', 'active')
            ->with(['policy'])
            ->get();

        foreach ($candidates as $candidate) {
            if (! hash_equals($candidate->key_hash, $hash)) {
                continue;
            }

            if (! $candidate->isActive()) {
                continue;
            }

            $candidate->forceFill(['last_used_at' => now()])->save();

            return $candidate;
        }

        return null;
    }
}
