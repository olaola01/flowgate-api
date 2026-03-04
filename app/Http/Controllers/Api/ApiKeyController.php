<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexApiKeyRequest;
use App\Http\Requests\Api\StoreApiKeyRequest;
use App\Http\Resources\Flowgate\ApiKeyResource;
use App\Http\Resources\Flowgate\ApiKeyWithSecretResource;
use App\Models\Flowgate\ApiKey;
use App\Services\Flowgate\ApiKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Handles API key lifecycle endpoints.
 */
class ApiKeyController extends Controller
{
    /**
     * Build a new controller instance.
     */
    public function __construct(private readonly ApiKeyService $apiKeyService) {}

    /**
     * List API keys with optional project filtering.
     *
     * @group API Keys
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     *
     * @queryParam project_id integer Filter keys by project ID. Example: 1
     * @queryParam per_page integer Number of records per page (max 100). Example: 20
     */
    public function index(IndexApiKeyRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        $query = ApiKey::query()->with(['project', 'policy'])->latest();

        if (isset($validated['project_id'])) {
            $query->where('project_id', (int) $validated['project_id']);
        }

        $perPage = isset($validated['per_page']) ? (int) $validated['per_page'] : 20;

        return ApiKeyResource::collection($query->paginate($perPage));
    }

    /**
     * Create a new API key.
     *
     * @group API Keys
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     * @header Idempotency-Key string Optional idempotency key for safe retries.
     *
     * @bodyParam project_id integer required Owning project ID. Example: 1
     * @bodyParam rate_limit_policy_id integer Optional rate limit policy ID. Example: 1
     * @bodyParam name string required Friendly key label. Example: Server Key
     * @bodyParam expires_at datetime Optional expiration timestamp. Example: 2026-12-31 23:59:59
     */
    public function store(StoreApiKeyRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $result = $this->apiKeyService->createKey(
            $payload['project_id'],
            $payload['rate_limit_policy_id'] ?? null,
            $payload['name'],
            $payload['expires_at'] ?? null,
        );

        /** @var ApiKey $apiKey */
        $apiKey = $result->apiKey;

        return new ApiKeyWithSecretResource($apiKey->loadMissing(['project', 'policy']), $result->plainKey)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Rotate an API key and return the new plaintext secret.
     *
     * @group API Keys
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     * @header Idempotency-Key string Optional idempotency key for safe retries.
     *
     * @urlParam apiKey integer required API key ID. Example: 1
     */
    public function rotate(ApiKey $apiKey): JsonResponse
    {
        $result = $this->apiKeyService->rotateKey($apiKey);

        /** @var ApiKey $rotated */
        $rotated = $result->apiKey;

        return new ApiKeyWithSecretResource($rotated->loadMissing(['project', 'policy']), $result->plainKey)
            ->response();
    }

    /**
     * Revoke an API key.
     *
     * @group API Keys
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     * @header Idempotency-Key string Optional idempotency key for safe retries.
     *
     * @urlParam apiKey integer required API key ID. Example: 1
     */
    public function revoke(ApiKey $apiKey): JsonResponse
    {
        $apiKey->forceFill([
            'status' => 'revoked',
            'revoked_at' => now(),
        ])->save();

        return ApiKeyResource::make($apiKey->loadMissing(['project', 'policy']))->response();
    }
}
