<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRateLimitPolicyRequest;
use App\Http\Resources\Flowgate\RateLimitPolicyResource;
use App\Models\Flowgate\RateLimitPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RateLimitPolicyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RateLimitPolicyResource::collection(RateLimitPolicy::query()->latest()->paginate(20));
    }

    public function store(StoreRateLimitPolicyRequest $request): JsonResponse
    {
        $policy = RateLimitPolicy::query()->create($request->validated());

        return RateLimitPolicyResource::make($policy)->response()->setStatusCode(201);
    }
}
