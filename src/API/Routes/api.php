<?php

use Illuminate\Support\Facades\Route;
use Modules\API\Http\Controllers\API\V1\CityFinder;
use Modules\API\Http\Controllers\API\V1\NatalCircleChartSvg;
use Modules\API\Http\Controllers\API\V1\NatalInterpreter;
use Modules\API\Http\Controllers\API\V1\TrackAnalytics;

Route::prefix('v1')->group(function () {
    Route::get('/track', [TrackAnalytics::class, 'track']);
    Route::post('/natal/svg', [NatalCircleChartSvg::class, 'generate']);
    Route::post('/natal/interpret/planet/{planetName}', [NatalInterpreter::class, 'planet']);
    Route::get('/city/find/{query}', [CityFinder::class, 'find']);
});
