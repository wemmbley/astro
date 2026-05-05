<?php

namespace App\Modules\Analytics\Infrastructure\Providers;

use App\Modules\Analytics\Domain\Contracts\GeoResolverContract;
use App\Modules\Analytics\Infrastructure\Geo\MaxMindGeoResolver;
use Illuminate\Support\ServiceProvider;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            GeoResolverContract::class,
            MaxMindGeoResolver::class,
        );
    }
}
