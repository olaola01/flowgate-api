<?php

namespace App\Http\Integrations\Flowgate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasStringBody;

class ProxyRequest extends Request implements HasBody
{
    use HasStringBody;

    protected Method $method;

    public function __construct(
        string $method,
        private readonly string $path,
        private readonly ?string $queryString,
        private readonly string $rawBody,
    ) {
        $this->method = Method::from(strtoupper($method));
    }

    public function resolveEndpoint(): string
    {
        $endpoint = '/'.ltrim($this->path, '/');

        if ($this->queryString !== null && $this->queryString !== '') {
            return $endpoint.'?'.$this->queryString;
        }

        return $endpoint;
    }

    protected function defaultBody(): ?string
    {
        if ($this->rawBody === '') {
            return null;
        }

        return $this->rawBody;
    }
}
