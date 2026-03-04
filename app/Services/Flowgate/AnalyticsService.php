<?php

namespace App\Services\Flowgate;

use App\Models\Flowgate\UsageAggregateHourly;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Computes and caches analytics metrics from aggregate tables.
 */
class AnalyticsService
{
    /**
     * Compute headline analytics metrics for the given window.
     *
     * @return array{total_requests: int, blocked_requests: int, error_requests: int, error_rate: float, avg_latency_ms: float}
     */
    public function overview(CarbonImmutable $from, CarbonImmutable $to, ?int $projectId = null): array
    {
        $cacheKey = sprintf('flowgate:analytics:overview:%s:%s:%s', $from->timestamp, $to->timestamp, $projectId ?? 'all');

        return $this->store()->remember($cacheKey, config('flowgate.analytics_cache_ttl_seconds', 60), function () use ($from, $to, $projectId): array {
            $query = UsageAggregateHourly::query()
                ->whereBetween('bucket_start', [$from, $to]);

            if ($projectId !== null) {
                $query->where('project_id', $projectId);
            }

            $totals = $query
                ->selectRaw('SUM(total_requests) as total_requests')
                ->selectRaw('SUM(blocked_requests) as blocked_requests')
                ->selectRaw('SUM(error_requests) as error_requests')
                ->selectRaw('SUM(latency_sum_ms) as latency_sum_ms')
                ->first();

            $total = (int) ($totals?->total_requests ?? 0);
            $latencySum = (int) ($totals?->latency_sum_ms ?? 0);

            return [
                'total_requests' => $total,
                'blocked_requests' => (int) ($totals?->blocked_requests ?? 0),
                'error_requests' => (int) ($totals?->error_requests ?? 0),
                'error_rate' => $total > 0 ? round(((int) ($totals?->error_requests ?? 0) / $total) * 100, 2) : 0.0,
                'avg_latency_ms' => $total > 0 ? round($latencySum / $total, 2) : 0.0,
            ];
        });
    }

    /**
     * Build a timeseries payload grouped by hourly buckets.
     *
     * @return array<int, array{bucket_start: mixed, total_requests: int, blocked_requests: int}>
     */
    public function timeseries(CarbonImmutable $from, CarbonImmutable $to, ?int $projectId = null): array
    {
        $query = UsageAggregateHourly::query()
            ->selectRaw('bucket_start')
            ->selectRaw('SUM(total_requests) as total_requests')
            ->selectRaw('SUM(blocked_requests) as blocked_requests')
            ->whereBetween('bucket_start', [$from, $to]);

        if ($projectId !== null) {
            $query->where('project_id', $projectId);
        }

        return $query
            ->groupBy('bucket_start')
            ->orderBy('bucket_start')
            ->get()
            ->map(fn ($row): array => [
                'bucket_start' => $row->bucket_start,
                'total_requests' => (int) $row->total_requests,
                'blocked_requests' => (int) $row->blocked_requests,
            ])
            ->all();
    }

    /**
     * Return top endpoints by request volume.
     *
     * @return array<int, array{route: string, total_requests: int}>
     */
    public function topEndpoints(CarbonImmutable $from, CarbonImmutable $to, ?int $projectId = null, int $limit = 10): array
    {
        $query = DB::table('usage_aggregates_hourly')
            ->select('route')
            ->selectRaw('SUM(total_requests) as total_requests')
            ->whereBetween('bucket_start', [$from, $to]);

        if ($projectId !== null) {
            $query->where('project_id', $projectId);
        }

        return $query
            ->groupBy('route')
            ->orderByDesc('total_requests')
            ->limit($limit)
            ->get()
            ->map(fn ($row): array => [
                'route' => $row->route,
                'total_requests' => (int) $row->total_requests,
            ])
            ->all();
    }

    /**
     * Resolve the configured cache store, with graceful fallback.
     */
    private function store(): Repository
    {
        $configuredStore = (string) config('flowgate.analytics_cache_store', config('cache.default'));

        try {
            return Cache::store($configuredStore);
        } catch (\Throwable) {
            return Cache::store(config('cache.default'));
        }
    }
}
