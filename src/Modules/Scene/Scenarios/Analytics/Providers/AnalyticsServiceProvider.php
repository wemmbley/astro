<?php

namespace Modules\Technical\Business\Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Business\Analytics\Contracts\GeoResolverContract;
use Modules\Technical\Business\Analytics\Geo\MaxMindGeoResolver;

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
