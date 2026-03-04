<?php

namespace App\Http\Integrations\Flowgate;

use Saloon\Http\Connector;

class UpstreamConnector extends Connector
{
    public function __construct(
        private readonly string $baseUrlValue,
        private readonly array $defaultHeaderBag = [],
    ) {}

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrlValue, '/');
    }

    protected function defaultHeaders(): array
    {
        return $this->defaultHeaderBag;
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => 10,
        ];
    }
}
