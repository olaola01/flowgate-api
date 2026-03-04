<?php

namespace App\Jobs\Flowgate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

/**
 * Aggregates hourly metrics into daily metric buckets.
 */
class AggregateUsageDailyJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly string $bucketDate) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date = now()->parse($this->bucketDate)->startOfDay();
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();

        $rows = DB::table('usage_aggregates_hourly')
            ->select('project_id', 'api_key_id', 'route', 'method')
            ->selectRaw('SUM(total_requests) as total_requests')
            ->selectRaw('SUM(blocked_requests) as blocked_requests')
            ->selectRaw('SUM(error_requests) as error_requests')
            ->selectRaw('SUM(latency_sum_ms) as latency_sum_ms')
            ->selectRaw('MAX(latency_p95_ms) as latency_p95_ms')
            ->whereBetween('bucket_start', [$start, $end])
            ->groupBy('project_id', 'api_key_id', 'route', 'method')
            ->get();

        foreach ($rows as $row) {
            DB::table('usage_aggregates_daily')->updateOrInsert(
                [
                    'project_id' => $row->project_id,
                    'api_key_id' => $row->api_key_id,
                    'bucket_date' => $date->toDateString(),
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
