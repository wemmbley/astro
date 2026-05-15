<?php

namespace workers\Jobs;

use DefStudio\Telegraph\Facades\Telegraph;
use Modules\Isolated\Analytics\Application\Services\AnalyticsService;

class TelegramBotSendDailyStats
{
    public function handle(AnalyticsService $analyticsService): void
    {
        Telegraph::message("
📊 *Статистика за {today()->format('d.m.Y')}*

Уникальных посетителей за сегодня: {$analyticsService->getSiteUniqueVisitsToday()}
Покупок совершено: Х
")->send();
    }
}
