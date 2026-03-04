<?php

namespace App\Jobs\Flowgate;

use App\Models\Flowgate\Project;
use App\Services\Flowgate\AnalyticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class WarmAnalyticsCacheJob implements ShouldQueue
{
    use Queueable;

    public function handle(AnalyticsService $analyticsService): void
    {
        $from = now()->subDay()->toImmutable();
        $to = now()->toImmutable();

        Project::query()->where('is_active', true)->pluck('id')->each(function ($projectId) use ($analyticsService, $from, $to): void {
            $analyticsService->overview($from, $to, (int) $projectId);
        });
    }
}
