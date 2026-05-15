<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use workers\Jobs\FlushAnalyticsBuffer;
use workers\Jobs\TelegramBotSendDailyStats;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$scheduleAnalytics = Schedule::job(FlushAnalyticsBuffer::class);

app()->isProduction()
    ? $scheduleAnalytics->everyThirtyMinutes()
    : $scheduleAnalytics->everySecond();

Schedule::job(TelegramBotSendDailyStats::class)->dailyAt('22:00');
