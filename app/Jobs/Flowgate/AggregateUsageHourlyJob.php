<?php

namespace App\Jobs\Flowgate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

/**
 * Aggregates raw request logs into hourly metric buckets.
 */
class AggregateUsageHourlyJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly string $bucketStart) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $start = now()->parse($this->bucketStart)->startOfHour();
        $end = $start->copy()->endOfHour();

        $rows = DB::table('request_logs')
            ->select('project_id', 'api_key_id', 'route', 'method')
            ->selectRaw('COUNT(*) as total_requests')
            ->selectRaw('SUM(CASE WHEN rate_limited = 1 THEN 1 ELSE 0 END) as blocked_requests')
            ->selectRaw('SUM(CASE WHEN status_code >= 400 THEN 1 ELSE 0 END) as error_requests')
            ->selectRaw('SUM(latency_ms) as latency_sum_ms')
            ->selectRaw('MAX(latency_ms) as latency_p95_ms')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('project_id', 'api_key_id', 'route', 'method')
            ->get();

        foreach ($rows as $row) {
            DB::table('usage_aggregates_hourly')->updateOrInsert(
                [
                    'project_id' => $row->project_id,
                    'api_key_id' => $row->api_key_id,
                    'bucket_start' => $start,
                    'route' => $row->route,
                    'method' => $row->method,
                ],
                [
                    'total_requests' => (int) $row->total_requests,
                    'blocked_requests' => (int) $row->blocked_requests,
                    'error_requests' => (int) $row->error_requests,
                    'latency_sum_ms' => (int) $row->latency_sum_ms,
                    'latency_p95_ms' => (int) $row->latency_p95_ms,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}
