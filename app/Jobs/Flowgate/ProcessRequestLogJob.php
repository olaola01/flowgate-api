<?php

namespace App\Jobs\Flowgate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessRequestLogJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly int $requestLogId) {}

    public function handle(): void
    {
        // Hook for enrichment/export pipelines; keeping minimal work in request path.
        Log::debug('Processed request log', ['request_log_id' => $this->requestLogId]);
    }
}
