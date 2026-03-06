<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\FlowgateLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Ensures each API request has a correlation ID and exposes it in responses.
 */
readonly class EnsureRequestCorrelationId
{
    /**
     * Create a new middleware instance.
     */
    public function __construct(private FlowgateLogger $logger) {}

    /**
     * Attach correlation ID to request context and response headers.
     */
    public function handle(Request $request, Closure $next)
    {
        $headerName = (string) config('flowgate.correlation_id_header', 'X-Request-Id');
        $requestId = (string) ($request->header($headerName) ?: Str::uuid()->toString());

        $request->attributes->set('flowgate_request_id', $requestId);

        $response = $next($request);
        $response->headers->set($headerName, $requestId);

        $this->logger->info('request.completed', [
            'method' => $request->method(),
            'status' => $response->getStatusCode(),
            'request_id' => $requestId,
        ]);

        return $response;
    }
}
