<?php

use API\Http\Controllers\API\V1\CityFinder;
use API\Http\Controllers\API\V1\NatalCircleChartSvg;
use API\Http\Controllers\API\V1\NatalInterpreter;
use API\Http\Controllers\API\V1\TrackAnalytics;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/track', [TrackAnalytics::class, 'track']);
    Route::post('/natal/svg', [NatalCircleChartSvg::class, 'generate']);
    Route::post('/natal/interpret/planet/{planetName}', [NatalInterpreter::class, 'planet']);
    Route::get('/city/find/{query}', [CityFinder::class, 'find']);
});
