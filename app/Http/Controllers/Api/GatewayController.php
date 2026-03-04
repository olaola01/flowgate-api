<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flowgate\ApiKey;
use App\Models\Flowgate\Project;
use App\Services\Flowgate\FlowgateLogger;
use App\Services\Flowgate\GatewayProxyService;
use App\Services\Flowgate\GatewayTelemetryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Proxies incoming requests to upstream APIs after auth and rate-limit checks.
 */
class GatewayController extends Controller
{
    /**
     * Build a new controller instance.
     */
    public function __construct(
        private readonly GatewayTelemetryService $telemetry,
        private readonly GatewayProxyService $proxyService,
        private readonly FlowgateLogger $logger,
    ) {}

    /**
     * Proxy a gateway request to the project's upstream API.
     *
     * @group Gateway
     *
     * @header X-Api-Key string required API key used for gateway authentication.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     *
     * @urlParam project string required Project slug. Example: primary-api
     * @urlParam path string Optional upstream path after project slug. Example: customers
     */
    public function __invoke(Request $request, Project $project, ?string $path = null): Response
    {
        /** @var ApiKey $apiKey */
        $apiKey = $request->attributes->get('flowgate_api_key');

        $start = microtime(true);

        try {
            $proxyResponse = $this->proxyService->forward($project, $request, $path);
        } catch (Throwable) {
            $this->telemetry->logAllowed($request, $project, $apiKey, 502, 0, 0);
            $this->logger->error('gateway.proxy.failed', [
                'project_id' => $project->id,
                'api_key_id' => $apiKey->id,
            ]);

            return response()->json(['message' => 'Upstream request failed'], 502);
        }

        $latencyMs = (int) round((microtime(true) - $start) * 1000);
        $responseBody = $proxyResponse->body;

        $this->telemetry->logAllowed(
            $request,
            $project,
            $apiKey,
            $proxyResponse->status,
            $latencyMs,
            strlen($responseBody),
        );

        $response = response($responseBody, $proxyResponse->status);

        foreach ($proxyResponse->headers as $headerName => $headerValue) {
            $response->headers->set($headerName, $headerValue);
        }

        $this->logger->info('gateway.proxy.succeeded', [
            'project_id' => $project->id,
            'api_key_id' => $apiKey->id,
            'status_code' => $proxyResponse->status,
            'latency_ms' => $latencyMs,
        ]);

        return $response;
    }
}
