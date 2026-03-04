<?php

namespace App\Services\Flowgate;

use App\Data\Flowgate\ProxyResponseData;
use App\Http\Integrations\Flowgate\Requests\ProxyRequest;
use App\Http\Integrations\Flowgate\UpstreamConnector;
use App\Models\Flowgate\Project;
use Illuminate\Http\Request;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;

class GatewayProxyService
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function forward(Project $project, Request $request, ?string $path = null): ProxyResponseData
    {
        $headers = collect($request->headers->all())
            ->reject(fn ($_value, $name) => in_array(strtolower($name), ['host', 'x-api-key', 'authorization'], true))
            ->map(fn ($values) => implode(',', $values))
            ->all();

        $connector = new UpstreamConnector($project->upstream_base_url, $headers);
        $response = $connector->send(new ProxyRequest(
            method: $request->method(),
            path: $path ?? '',
            queryString: $request->getQueryString(),
            rawBody: (string) $request->getContent(),
        ));

        return new ProxyResponseData(
            status: $response->status(),
            body: $response->body(),
            headers: $this->responseHeaders($response),
        );
    }

    private function responseHeaders(Response $response): array
    {
        $headers = [];

        foreach (['content-type', 'cache-control'] as $headerName) {
            $value = $response->header($headerName);

            if (is_string($value) && $value !== '') {
                $headers[$headerName] = $value;
            }
        }

        return $headers;
    }
}
