<?php

use App\Modules\AI\Infrastructure\Providers\AIServiceProvider;
use app\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    AIServiceProvider::class,
    \App\Modules\Matrix\Infrastructure\Providers\MatrixServiceProvider::class,
    \App\Modules\Analytics\Infrastructure\Providers\AnalyticsServiceProvider::class,
];
