<?php

namespace App\Http\Middleware;

use App\Services\Flowgate\FlowgateLogger;
use Closure;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Replays responses for repeated mutating requests with the same idempotency key.
 */
readonly class HandleIdempotencyKey
{
    /**
     * Create a new middleware instance.
     */
    public function __construct(private FlowgateLogger $logger) {}

    /**
     * Handle idempotency key lookups and writes.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return $next($request);
        }

        $key = $request->header('Idempotency-Key');

        if (! is_string($key) || trim($key) === '') {
            return $next($request);
        }

        $cacheKey = $this->cacheKey($request, $key);
        $cached = $this->store()->get($cacheKey);

        if (is_array($cached)) {
            $this->logger->info('idempotency.replayed', [
                'idempotency_key_hash' => sha1($key),
                'method' => $request->method(),
            ]);

            $response = response((string) ($cached['body'] ?? ''), (int) ($cached['status'] ?? 200));

            foreach ((array) ($cached['headers'] ?? []) as $name => $value) {
                $response->headers->set((string) $name, (string) $value);
            }

            $response->headers->set('X-Idempotency-Status', 'replayed');

            return $response;
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        if ($response->getStatusCode() >= 500) {
            return $response;
        }

        $payload = [
            'status' => $response->getStatusCode(),
            'body' => method_exists($response, 'getContent') ? (string) $response->getContent() : '',
            'headers' => [
                'Content-Type' => (string) $response->headers->get('Content-Type'),
            ],
        ];

        $ttl = (int) config('flowgate.idempotency_ttl_seconds', 86400);
        $this->store()->put($cacheKey, $payload, $ttl);
        $response->headers->set('X-Idempotency-Status', 'stored');

        $this->logger->info('idempotency.stored', [
            'idempotency_key_hash' => sha1($key),
            'method' => $request->method(),
            'status' => $response->getStatusCode(),
        ]);

        return $response;
    }

    /**
     * Build a deterministic cache key for an idempotent request.
     */
    private function cacheKey(Request $request, string $idempotencyKey): string
    {
        $fingerprint = hash('sha256', implode('|', [
            $request->method(),
            $request->route()?->uri() ?: $request->path(),
            $request->getQueryString() ?: '',
            (string) $request->getContent(),
        ]));

        return 'flowgate:idempotency:'.hash('sha256', $idempotencyKey).':'.$fingerprint;
    }

    /**
     * Resolve cache store for idempotency writes.
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
