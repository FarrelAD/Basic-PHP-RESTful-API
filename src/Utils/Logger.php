<?php

declare(strict_types=1);

namespace App\Utils;

class Logger
{
    public static function error(string $message): void
    {
        $logDir = dirname(__DIR__, 2) . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/error.log';
        $timestamp = date('Y-m-d H:i:s');
        error_log("[{$timestamp}] {$message}" . PHP_EOL, 3, $logFile);
    }
}
