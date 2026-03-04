<?php

namespace App\Services\Flowgate;

use App\Jobs\Flowgate\ProcessRequestLogJob;
use App\Models\Flowgate\ApiKey;
use App\Models\Flowgate\Project;
use App\Models\Flowgate\RequestLog;
use Illuminate\Http\Request;

class GatewayTelemetryService
{
    public function logAllowed(
        Request $request,
        Project $project,
        ApiKey $apiKey,
        int $statusCode,
        int $latencyMs,
        int $responseBytes,
    ): void {
        $payload = $this->basePayload($request, $project, $apiKey);
        $payload['status_code'] = $statusCode;
        $payload['latency_ms'] = $latencyMs;
        $payload['response_bytes'] = $responseBytes;
        $payload['rate_limited'] = false;

        $log = RequestLog::query()->create($payload);
        ProcessRequestLogJob::dispatch($log->id);
    }

    public function logBlocked(Request $request, ApiKey $apiKey, int $statusCode): void
    {
        $payload = $this->basePayload($request, $apiKey->project, $apiKey);
        $payload['status_code'] = $statusCode;
        $payload['latency_ms'] = 0;
        $payload['response_bytes'] = 0;
        $payload['rate_limited'] = true;

        $log = RequestLog::query()->create($payload);
        ProcessRequestLogJob::dispatch($log->id);
    }

    private function basePayload(Request $request, Project $project, ApiKey $apiKey): array
    {
        return [
            'project_id' => $project->id,
            'api_key_id' => $apiKey->id,
            'method' => $request->method(),
            'route' => '/'.ltrim($request->path(), '/'),
            'request_bytes' => strlen((string) $request->getContent()),
            'client_ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 512),
            'trace_id' => $request->header('X-Request-Id') ?: $request->header('X-Trace-Id'),
            'created_at' => now(),
        ];
    }
}
