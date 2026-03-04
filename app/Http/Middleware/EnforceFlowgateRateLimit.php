<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\GatewayTelemetryService;
use App\Services\Flowgate\RateLimiterService;
use Closure;
use Illuminate\Http\Request;

class EnforceFlowgateRateLimit
{
    public function __construct(
        private readonly RateLimiterService $rateLimiterService,
        private readonly GatewayTelemetryService $telemetryService,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->attributes->get('flowgate_api_key');

        $result = $this->rateLimiterService->checkAndHit($apiKey, $request);

        if (! $result['allowed']) {
            $this->telemetryService->logBlocked($request, $apiKey, 429);

            return response()->json([
                'message' => 'Rate limit exceeded',
                'limit' => $result['limit'],
                'remaining' => $result['remaining'],
                'reset_at' => $result['reset_at'],
            ], 429);
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);
        $response->headers->set('X-RateLimit-Limit', (string) $result['limit']);
        $response->headers->set('X-RateLimit-Remaining', (string) $result['remaining']);
        $response->headers->set('X-RateLimit-Reset', (string) $result['reset_at']);

        return $response;
    }
}
