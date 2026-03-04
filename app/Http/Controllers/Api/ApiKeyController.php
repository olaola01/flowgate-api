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

class ApiKeyController extends Controller
{
    public function __construct(private readonly ApiKeyService $apiKeyService) {}

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

        return (new ApiKeyWithSecretResource($apiKey->loadMissing(['project', 'policy']), $result->plainKey))
            ->response()
            ->setStatusCode(201);
    }

    public function rotate(ApiKey $apiKey): JsonResponse
    {
        $result = $this->apiKeyService->rotateKey($apiKey);

        /** @var ApiKey $rotated */
        $rotated = $result->apiKey;

        return (new ApiKeyWithSecretResource($rotated->loadMissing(['project', 'policy']), $result->plainKey))
            ->response();
    }

    public function revoke(ApiKey $apiKey): JsonResponse
    {
        $apiKey->forceFill([
            'status' => 'revoked',
            'revoked_at' => now(),
        ])->save();

        return ApiKeyResource::make($apiKey->loadMissing(['project', 'policy']))->response();
    }
}
