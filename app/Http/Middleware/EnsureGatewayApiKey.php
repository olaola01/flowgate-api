<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\ApiKeyService;
use App\Services\Flowgate\FlowgateLogger;
use Closure;
use Illuminate\Http\Request;

/**
 * Resolves and validates the API key attached to gateway traffic.
 */
class EnsureGatewayApiKey
{
    /**
     * Create a new middleware instance.
     */
    public function __construct(
        private readonly ApiKeyService $apiKeyService,
        private readonly FlowgateLogger $logger,
    ) {}

    /**
     * Ensure an active API key exists for the requested project.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Api-Key')
            ?? $request->bearerToken();

        if (! is_string($token) || $token === '') {
            $this->logger->warning('gateway.auth.failed', [
                'reason' => 'missing_api_key',
            ]);

            return response()->json(['message' => 'API key is required'], 401);
        }

        $apiKey = $this->apiKeyService->resolveActiveKey($token, $request->route('project')->id);

        if ($apiKey === null) {
            $this->logger->warning('gateway.auth.failed', [
                'reason' => 'invalid_api_key',
                'token_prefix' => substr($token, 0, 8),
            ]);

            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $request->attributes->set('flowgate_api_token', $token);
        $request->attributes->set('flowgate_api_key', $apiKey);

        return $next($request);
    }
}
