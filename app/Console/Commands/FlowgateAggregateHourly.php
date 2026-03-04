<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\AggregateUsageHourlyJob;
use Illuminate\Console\Command;

/**
 * Queues hourly aggregation for request log metrics.
 */
class FlowgateAggregateHourly extends Command
{
    protected $signature = 'flowgate:aggregate-hourly {--hour=}';

    protected $description = 'Aggregate request logs into hourly analytics buckets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hour = $this->option('hour') ? now()->parse((string) $this->option('hour')) : now()->subHour();
        AggregateUsageHourlyJob::dispatch($hour->startOfHour()->toDateTimeString());

        $this->info('Flowgate hourly aggregation queued for '.$hour->startOfHour()->toDateTimeString());

        return self::SUCCESS;
    }
}
