<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\WarmAnalyticsCacheJob;
use Illuminate\Console\Command;

class FlowgateWarmCache extends Command
{
    protected $signature = 'flowgate:warm-cache';

    protected $description = 'Warm Flowgate analytics cache';

    public function handle(): int
    {
        WarmAnalyticsCacheJob::dispatch();

        $this->info('Flowgate analytics cache warmup queued');

        return self::SUCCESS;
    }
}
