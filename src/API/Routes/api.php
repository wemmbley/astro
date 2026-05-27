<?php

use API\Http\Controllers\API\V1\CityFinder;
use API\Http\Controllers\API\V1\Messenger;
use API\Http\Controllers\API\V1\NatalCircleChartSvg;
use API\Http\Controllers\API\V1\NatalInterpreter;
use API\Http\Controllers\API\V1\Notifications;
use API\Http\Controllers\API\V1\TrackAnalytics;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/track', [TrackAnalytics::class, 'track']);
    Route::post('/natal/svg', [NatalCircleChartSvg::class, 'generate']);
    Route::post('/natal/interpret/planet/{planetName}', [NatalInterpreter::class, 'planet']);
    Route::get('/city/find/{query}/{page?}', [CityFinder::class, 'find']);

    Route::middleware(['web', 'auth', 'verified'])->group(function () {
        Route::prefix('dialogues/{id}')->group(function () {
            Route::get('/messages',      [Messenger::class, 'messages']);
            Route::post('/messages',     [Messenger::class, 'send']);
            Route::post('/read',         [Messenger::class, 'read']);
            Route::get('/messages/poll', [Messenger::class, 'poll']);
        });

        Route::prefix('/notifications')->group(function () {
            Route::get('/', [Notifications::class, 'index']);
            Route::post('/{id}/read', [Notifications::class, 'read']);
            Route::post('/readAll', [Notifications::class, 'readAll']);
        });
    });
});
