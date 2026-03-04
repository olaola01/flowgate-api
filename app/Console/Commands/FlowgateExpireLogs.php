<?php

namespace App\Console\Commands;

use App\Jobs\Flowgate\ExpireOldLogsJob;
use Illuminate\Console\Command;

class FlowgateExpireLogs extends Command
{
    protected $signature = 'flowgate:expire-logs';

    protected $description = 'Delete old request logs based on retention policy';

    public function handle(): int
    {
        ExpireOldLogsJob::dispatch();

        $this->info('Flowgate request log expiration queued');

        return self::SUCCESS;
    }
}
