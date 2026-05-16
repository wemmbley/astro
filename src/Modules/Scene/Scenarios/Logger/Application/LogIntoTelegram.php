<?php

namespace Modules\Technical\Business\Logger\Application;

use DefStudio\Telegraph\Facades\Telegraph;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class LogIntoTelegram extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        # Disable Telegram Throw-Notification for local develop.
        if(!app()->isProduction()) {
            return;
        }

        try {

            $exception = $record->context['exception'] ?? null;

            $trace = $exception?->getTrace() ?? [];

            $filtered = array_filter($trace, function ($item) {

                $file = $item['file'] ?? '';

                return !str_contains($file, '/vendor/');
            });

            $filtered = array_slice($filtered, 0, 5);

            $traceText = collect($filtered)
                ->map(function ($item, $i) {

                    return sprintf(
                        "#%d %s:%d",
                        $i,
                        $item['file'] ?? 'unknown',
                        $item['line'] ?? 0,
                    );
                })
                ->implode("\n");

            $message = "
                🚨 <b>CRITICAL !!!</b>

                <b>{$record->message}</b>

                <pre>{$traceText}</pre>
            ";

            Telegraph::bot(config('logging.channels.telegram.token'))
                ->chat(config('logging.channels.telegram.chat'))
                ->message(mb_substr($message, 0, 4000))
                ->send();

        } catch (\Throwable $e) {

        }
    }
}
