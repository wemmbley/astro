<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('/track', [\App\Http\Controllers\API\TrackAnalytics::class, 'track']);
    });
});
