<?php

namespace App\Services\Flowgate;

use Illuminate\Support\Facades\Log;

/**
 * Emits structured logs for Flowgate domain events.
 */
class FlowgateLogger
{
    /**
     * Log an informational Flowgate event.
     *
     * @param  array<string, mixed>  $context
     */
    public function info(string $event, array $context = []): void
    {
        Log::channel('flowgate')->info($event, $this->withDefaults($context));
    }

    /**
     * Log a warning Flowgate event.
     *
     * @param  array<string, mixed>  $context
     */
    public function warning(string $event, array $context = []): void
    {
        Log::channel('flowgate')->warning($event, $this->withDefaults($context));
    }

    /**
     * Log an error Flowgate event.
     *
     * @param  array<string, mixed>  $context
     */
    public function error(string $event, array $context = []): void
    {
        Log::channel('flowgate')->error($event, $this->withDefaults($context));
    }

    /**
     * Attach shared structured context to every log record.
     *
     * @param  array<string, mixed>  $context
     * @return array<string, mixed>
     */
    private function withDefaults(array $context): array
    {
        return array_merge([
            'service' => 'flowgate',
            'request_id' => request()?->attributes->get('flowgate_request_id'),
            'path' => request()?->path(),
        ], $context);
    }
}
