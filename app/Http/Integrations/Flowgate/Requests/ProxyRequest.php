<?php

namespace App\Http\Integrations\Flowgate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasStringBody;

/**
 * Saloon request that mirrors an incoming gateway request to upstream.
 */
class ProxyRequest extends Request implements HasBody
{
    use HasStringBody;

    protected Method $method;

    /**
     * Create a new proxy request instance.
     */
    public function __construct(
        string $method,
        private readonly string $path,
        private readonly ?string $queryString,
        private readonly string $rawBody,
    ) {
        $this->method = Method::from(strtoupper($method));
    }

    /**
     * Resolve the upstream endpoint path and query string.
     */
    public function resolveEndpoint(): string
    {
        $endpoint = '/'.ltrim($this->path, '/');

        if ($this->queryString !== null && $this->queryString !== '') {
            return $endpoint.'?'.$this->queryString;
        }

        return $endpoint;
    }

    /**
     * Resolve the raw request body for the upstream call.
     */
    protected function defaultBody(): ?string
    {
        if ($this->rawBody === '') {
            return null;
        }

        return $this->rawBody;
    }
}
