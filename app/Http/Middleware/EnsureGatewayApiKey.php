<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\ApiKeyService;
use Closure;
use Illuminate\Http\Request;

class EnsureGatewayApiKey
{
    public function __construct(private readonly ApiKeyService $apiKeyService) {}

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
