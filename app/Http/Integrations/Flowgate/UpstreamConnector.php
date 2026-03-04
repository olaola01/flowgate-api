<?php

namespace App\Http\Integrations\Flowgate;

use Saloon\Http\Connector;

/**
 * Saloon connector for forwarding gateway requests to a project's upstream API.
 */
class UpstreamConnector extends Connector
{
    /**
     * Create a new connector instance.
     *
     * @param  array<string, string>  $defaultHeaderBag
     */
    public function __construct(
        private readonly string $baseUrlValue,
        private readonly array $defaultHeaderBag = [],
    ) {}

    /**
     * Resolve the upstream base URL.
     */
    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrlValue, '/');
    }

    /**
     * Provide default headers to every upstream request.
     *
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return $this->defaultHeaderBag;
    }

    /**
     * Provide default connector configuration.
     *
     * @return array<string, int>
     */
    protected function defaultConfig(): array
    {
        return [
            'timeout' => 10,
        ];
    }
}
