<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/track', [\App\Http\Controllers\API\TrackAnalytics::class, 'track']);
    Route::get('/city/find/{query}', [\App\Http\Controllers\API\CityFinder::class, 'find']);
});
