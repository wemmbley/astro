<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TrackAnalytics;
use App\Http\Controllers\API\NatalCircleChartSvg;
use App\Http\Controllers\API\NatalInterpreter;
use App\Http\Controllers\API\CityFinder;

Route::prefix('v1')->group(function () {
    Route::get('/track', [TrackAnalytics::class, 'track']);
    Route::post('/natal/svg', [NatalCircleChartSvg::class, 'generate']);
    Route::get('/natal/interpret/planet/{planetName}', [NatalInterpreter::class, 'planet']);
    Route::get('/city/find/{query}', [CityFinder::class, 'find']);
});
