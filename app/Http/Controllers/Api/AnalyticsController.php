<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AnalyticsOverviewRequest;
use App\Http\Requests\Api\AnalyticsTopEndpointsRequest;
use App\Http\Resources\Flowgate\AnalyticsOverviewResource;
use App\Http\Resources\Flowgate\AnalyticsTimeseriesPointResource;
use App\Http\Resources\Flowgate\TopEndpointResource;
use App\Services\Flowgate\AnalyticsService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Serves aggregated analytics endpoints for Flowgate.
 */
class AnalyticsController extends Controller
{
    /**
     * Build a new controller instance.
     */
    public function __construct(private readonly AnalyticsService $analytics) {}

    /**
     * Get overview metrics for a date window.
     *
     * @group Analytics
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     *
     * @queryParam from datetime Inclusive window start. Example: 2026-03-03 00:00:00
     * @queryParam to datetime Inclusive window end. Example: 2026-03-04 00:00:00
     * @queryParam project_id integer Filter by project ID. Example: 1
     */
    public function overview(AnalyticsOverviewRequest $request): AnalyticsOverviewResource
    {
        [$from, $to, $projectId] = $this->resolvedWindow($request->validated());

        return AnalyticsOverviewResource::make($this->analytics->overview($from, $to, $projectId));
    }

    /**
     * Get hourly usage points for charting.
     *
     * @group Analytics
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     *
     * @queryParam from datetime Inclusive window start. Example: 2026-03-03 00:00:00
     * @queryParam to datetime Inclusive window end. Example: 2026-03-04 00:00:00
     * @queryParam project_id integer Filter by project ID. Example: 1
     */
    public function timeseries(AnalyticsOverviewRequest $request): AnonymousResourceCollection
    {
        [$from, $to, $projectId] = $this->resolvedWindow($request->validated());

        return AnalyticsTimeseriesPointResource::collection(
            collect($this->analytics->timeseries($from, $to, $projectId))
        );
    }

    /**
     * Get top endpoints by request volume.
     *
     * @group Analytics
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     * @header X-Request-Id string Optional correlation ID. If omitted, one is generated.
     *
     * @queryParam from datetime Inclusive window start. Example: 2026-03-03 00:00:00
     * @queryParam to datetime Inclusive window end. Example: 2026-03-04 00:00:00
     * @queryParam project_id integer Filter by project ID. Example: 1
     * @queryParam limit integer Number of endpoints to return. Example: 10
     */
    public function topEndpoints(AnalyticsTopEndpointsRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        [$from, $to, $projectId] = $this->resolvedWindow($validated);
        $limit = isset($validated['limit']) ? (int) $validated['limit'] : 10;

        return TopEndpointResource::collection(
            collect($this->analytics->topEndpoints($from, $to, $projectId, $limit))
        );
    }

    /**
     * Resolve the analytics window and optional project scope.
     *
     * @param  array<string, mixed>  $validated
     * @return array{0: CarbonImmutable, 1: CarbonImmutable, 2: int|null}
     */
    private function resolvedWindow(array $validated): array
    {
        $from = isset($validated['from'])
            ? CarbonImmutable::parse((string) $validated['from'])
            : now()->subDay()->toImmutable();

        $to = isset($validated['to'])
            ? CarbonImmutable::parse((string) $validated['to'])
            : now()->toImmutable();

        $projectId = isset($validated['project_id']) ? (int) $validated['project_id'] : null;

        return [$from, $to, $projectId];
    }
}
