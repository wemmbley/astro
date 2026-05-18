<?php

namespace Modules\Scene\Scenarios\Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Scenarios\Analytics\Contracts\GeoResolverContract;
use Modules\Scene\Scenarios\Analytics\Geo\MaxMindGeoResolver;

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
