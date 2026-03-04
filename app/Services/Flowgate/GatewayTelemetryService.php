<?php

namespace App\Services\Flowgate;

use App\Jobs\Flowgate\ProcessRequestLogJob;
use App\Models\Flowgate\ApiKey;
use App\Models\Flowgate\Project;
use App\Models\Flowgate\RequestLog;
use Illuminate\Http\Request;

/**
 * Persists gateway telemetry and dispatches post-processing jobs.
 */
class GatewayTelemetryService
{
    /**
     * Create a new service instance.
     */
    public function __construct(private readonly FlowgateLogger $logger) {}

    /**
     * Log an allowed upstream request.
     */
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
        $this->logger->info('gateway.telemetry.logged', [
            'request_log_id' => $log->id,
            'api_key_id' => $apiKey->id,
            'status_code' => $statusCode,
            'rate_limited' => false,
        ]);
    }

    /**
     * Log a blocked request, typically for rate limiting.
     */
    public function logBlocked(Request $request, ApiKey $apiKey, int $statusCode): void
    {
        $payload = $this->basePayload($request, $apiKey->project, $apiKey);
        $payload['status_code'] = $statusCode;
        $payload['latency_ms'] = 0;
        $payload['response_bytes'] = 0;
        $payload['rate_limited'] = true;

        $log = RequestLog::query()->create($payload);
        ProcessRequestLogJob::dispatch($log->id);
        $this->logger->warning('gateway.telemetry.logged', [
            'request_log_id' => $log->id,
            'api_key_id' => $apiKey->id,
            'status_code' => $statusCode,
            'rate_limited' => true,
        ]);
    }

    /**
     * Build the baseline telemetry payload from an incoming request.
     *
     * @return array<string, int|string|null|\Illuminate\Support\Carbon>
     */
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
