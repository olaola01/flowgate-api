<?php

namespace App\Data\Flowgate;

class ProxyResponseData
{
    public function __construct(
        public readonly int $status,
        public readonly string $body,
        public readonly array $headers,
    ) {}
}
