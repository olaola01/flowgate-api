<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\ApiKeyService;
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
    public function __construct(private readonly ApiKeyService $apiKeyService) {}

    /**
     * Ensure an active API key exists for the requested project.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Api-Key')
            ?? $request->bearerToken();

        if (! is_string($token) || $token === '') {
            return response()->json(['message' => 'API key is required'], 401);
        }

        $apiKey = $this->apiKeyService->resolveActiveKey($token, $request->route('project')->id);

        if ($apiKey === null) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $request->attributes->set('flowgate_api_token', $token);
        $request->attributes->set('flowgate_api_key', $apiKey);

        return $next($request);
    }
}
