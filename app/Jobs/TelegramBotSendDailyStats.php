<?php

namespace App\Jobs;

use App\Modules\Analytics\Application\Services\AnalyticsService;
use DefStudio\Telegraph\Facades\Telegraph;

class TelegramBotSendDailyStats
{
    public function handle(AnalyticsService $analyticsService): void
    {
        Telegraph::message("
📊 *Статистика за {today()->format('d.m.Y')}*

Уникальных посетителей за сегодня: {$analyticsService->getSiteUniqueVisitsToday()}
")->send();
    }
}
