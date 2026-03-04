<?php

namespace App\Services\Flowgate;

use App\Models\Flowgate\ApiKey;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Performs cache-backed rate-limit checks for gateway requests.
 */
class RateLimiterService
{
    /**
     * Evaluate and increment counters for the incoming request.
     *
     * @return array{allowed: bool, limit: int, remaining: int, reset_at: int}
     */
    public function checkAndHit(ApiKey $apiKey, Request $request): array
    {
        $policy = $apiKey->policy;
        $limit = $policy?->requests_per_minute ?? 60;
        $windowSeconds = 60;

        $route = trim($request->path(), '/');
        $window = (int) floor(now()->timestamp / $windowSeconds);
        $key = sprintf('flowgate:rl:%d:%s:%s:%d', $apiKey->id, $request->method(), sha1($route), $window);

        $store = $this->store();
        $store->add($key, 0, $windowSeconds);
        $current = (int) $store->increment($key);

        $resetAt = ($window + 1) * $windowSeconds;
        $remaining = max(0, $limit - $current);

        return [
            'allowed' => $current <= $limit,
            'limit' => $limit,
            'remaining' => $remaining,
            'reset_at' => $resetAt,
        ];
    }

    /**
     * Resolve the configured cache store, with graceful fallback.
     */
    private function store(): Repository
    {
        $configuredStore = (string) config('flowgate.rate_limit_store', config('cache.default'));

        try {
            return Cache::store($configuredStore);
        } catch (\Throwable) {
            return Cache::store(config('cache.default'));
        }
    }
}
