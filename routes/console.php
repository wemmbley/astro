<?php

use App\Jobs\FlushAnalyticsBuffer;
use App\Jobs\TelegramBotSendDailyStats;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$scheduleAnalytics = Schedule::job(FlushAnalyticsBuffer::class);

app()->isProduction()
    ? $scheduleAnalytics->everyThirtyMinutes()
    : $scheduleAnalytics->everySecond();

Schedule::job(TelegramBotSendDailyStats::class)->dailyAt('22:00');
