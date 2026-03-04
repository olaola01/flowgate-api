<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRateLimitPolicyRequest;
use App\Http\Resources\Flowgate\RateLimitPolicyResource;
use App\Models\Flowgate\RateLimitPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Handles rate limit policy CRUD endpoints.
 */
class RateLimitPolicyController extends Controller
{
    /**
     * List available rate limit policies.
     *
     * @group Policies
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     *
     * @queryParam page integer Page number. Example: 1
     * @queryParam per_page integer Number of records per page (max 100). Example: 20
     */
    public function index(): AnonymousResourceCollection
    {
        return RateLimitPolicyResource::collection(RateLimitPolicy::query()->latest()->paginate(20));
    }

    /**
     * Create a new rate limit policy.
     *
     * @group Policies
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     *
     * @bodyParam project_id integer Optional project scope for this policy. Example: 1
     * @bodyParam name string required Policy name. Example: Starter
     * @bodyParam requests_per_minute integer required Allowed requests each minute. Example: 60
     * @bodyParam requests_per_hour integer required Allowed requests each hour. Example: 1000
     * @bodyParam burst_limit integer required Short burst allowance. Example: 120
     * @bodyParam is_active boolean Policy active flag. Example: true
     */
    public function store(StoreRateLimitPolicyRequest $request): JsonResponse
    {
        $policy = RateLimitPolicy::query()->create($request->validated());

        return RateLimitPolicyResource::make($policy)->response()->setStatusCode(201);
    }
}
