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

class AnalyticsController extends Controller
{
    public function __construct(private readonly AnalyticsService $analytics) {}

    public function overview(AnalyticsOverviewRequest $request): AnalyticsOverviewResource
    {
        [$from, $to, $projectId] = $this->resolvedWindow($request->validated());

        return AnalyticsOverviewResource::make($this->analytics->overview($from, $to, $projectId));
    }

    public function timeseries(AnalyticsOverviewRequest $request): AnonymousResourceCollection
    {
        [$from, $to, $projectId] = $this->resolvedWindow($request->validated());

        return AnalyticsTimeseriesPointResource::collection(
            collect($this->analytics->timeseries($from, $to, $projectId))
        );
    }

    public function topEndpoints(AnalyticsTopEndpointsRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        [$from, $to, $projectId] = $this->resolvedWindow($validated);
        $limit = isset($validated['limit']) ? (int) $validated['limit'] : 10;

        return TopEndpointResource::collection(
            collect($this->analytics->topEndpoints($from, $to, $projectId, $limit))
        );
    }

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
