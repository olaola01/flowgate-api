<?php

namespace App\Logging;

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;

/**
 * Applies JSON formatting to log handlers for structured logs.
 */
class UseJsonFormatter
{
    /**
     * Customize the logger instance handlers.
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new JsonFormatter);
        }
    }
}
