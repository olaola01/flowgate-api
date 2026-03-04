<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flowgate\ApiKey;
use App\Models\Flowgate\Project;
use App\Services\Flowgate\GatewayProxyService;
use App\Services\Flowgate\GatewayTelemetryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GatewayController extends Controller
{
    public function __construct(
        private readonly GatewayTelemetryService $telemetry,
        private readonly GatewayProxyService $proxyService,
    ) {}

    public function __invoke(Request $request, Project $project, ?string $path = null): Response
    {
        /** @var ApiKey $apiKey */
        $apiKey = $request->attributes->get('flowgate_api_key');

        $start = microtime(true);

        try {
            $proxyResponse = $this->proxyService->forward($project, $request, $path);
        } catch (Throwable) {
            $this->telemetry->logAllowed($request, $project, $apiKey, 502, 0, 0);

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

        return $response;
    }
}
