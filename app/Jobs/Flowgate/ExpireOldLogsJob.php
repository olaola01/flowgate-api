<?php

namespace App\Jobs\Flowgate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

/**
 * Deletes request logs that exceed the configured retention window.
 */
class ExpireOldLogsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cutoff = now()->subDays((int) config('flowgate.request_log_retention_days', 30));

        DB::table('request_logs')
            ->where('created_at', '<', $cutoff)
            ->delete();
    }
}
