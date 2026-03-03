<?php

namespace Savan\GchatErrorAlert;

use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Monolog\LogRecord;

class GChatLogHandler extends AbstractProcessingHandler
{
    protected function write($record): void
    {
        if (!config('gchat-alert.enabled')) {
            return;
        }

        $webhook = config('gchat-alert.webhook');

        if (!$webhook) {
            return;
        }

        try {
            if ($record instanceof LogRecord) {
                $level = $record->level->getName();
                $message = $record->message;
            } else {
                $level = $record['level_name'];
                $message = $record['message'];
            }
            // Ignore CLI / Artisan / Queue errors
            if (str_contains($message, 'Route::getTable')) {
                return;
            }
            Http::post($webhook, [
                'text' =>
                    "🚨 ".config('app.name')." Error Alert\n\n" .
                    "Level: {$level}\n" .
                    "Message: {$message}\n" .
                    "Time: " . now()
            ]);

        } catch (\Throwable $e) {
            // Prevent infinite loop
        }
    }
}
