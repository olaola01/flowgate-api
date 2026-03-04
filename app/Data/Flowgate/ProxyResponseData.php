<?php

namespace App\Data\Flowgate;

/**
 * Represents a normalized upstream response returned by the proxy service.
 */
class ProxyResponseData
{
    /**
     * Create a new proxy response data object.
     *
     * @param  array<string, string>  $headers
     */
    public function __construct(
        public readonly int $status,
        public readonly string $body,
        public readonly array $headers,
    ) {}
}
