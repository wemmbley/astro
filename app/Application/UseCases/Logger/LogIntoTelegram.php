<?php

namespace App\Application\UseCases\Logger;

use DefStudio\Telegraph\Facades\Telegraph;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class LogIntoTelegram extends AbstractProcessingHandler
{

    protected function write(LogRecord $record): void
    {
        try {
            Telegraph::bot(config('logging.channels.telegram.token'))
                ->chat(config('logging.channels.telegram.chat'))
                ->message("🚨 *CRITICAL!!!*\n\n{$record->message}")
                ->send();
        } catch (\Throwable $e) {

        }
    }
}
