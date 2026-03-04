<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\WarmAnalyticsCacheJob;
use Illuminate\Console\Command;

/**
 * Queues cache warmup for analytics overview endpoints.
 */
class FlowgateWarmCache extends Command
{
    protected $signature = 'flowgate:warm-cache';

    protected $description = 'Warm Flowgate analytics cache';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        WarmAnalyticsCacheJob::dispatch();

        $this->info('Flowgate analytics cache warmup queued');

        return self::SUCCESS;
    }
}
