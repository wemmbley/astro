<?php

use Modules\Isolated\AI\Infrastructure\Providers\AIServiceProvider;

return [
    AIServiceProvider::class,
    \Modules\Isolated\Analytics\Infrastructure\Providers\AnalyticsServiceProvider::class,
    \Matrix\Infrastructure\Providers\MatrixServiceProvider::class,
    Providers\FortifyServiceProvider::class,
    Providers\AppServiceProvider::class,
];
