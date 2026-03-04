<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\ExpireOldLogsJob;
use Illuminate\Console\Command;

/**
 * Queues deletion of expired request logs.
 */
class FlowgateExpireLogs extends Command
{
    protected $signature = 'flowgate:expire-logs';

    protected $description = 'Delete old request logs based on retention policy';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        ExpireOldLogsJob::dispatch();

        $this->info('Flowgate request log expiration queued');

        return self::SUCCESS;
    }
}
