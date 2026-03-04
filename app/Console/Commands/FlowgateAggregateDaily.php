<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\AggregateUsageDailyJob;
use Illuminate\Console\Command;

class FlowgateAggregateDaily extends Command
{
    protected $signature = 'flowgate:aggregate-daily {--date=}';

    protected $description = 'Aggregate hourly analytics into daily buckets';

    public function handle(): int
    {
        $date = $this->option('date') ? now()->parse((string) $this->option('date')) : now()->subDay();
        AggregateUsageDailyJob::dispatch($date->startOfDay()->toDateString());

        $this->info('Flowgate daily aggregation queued for '.$date->startOfDay()->toDateString());

        return self::SUCCESS;
    }
}
