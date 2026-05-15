<?php

namespace Modules\Analytics\Infrastructure\Providers;

use Modules\Analytics\Domain\Contracts\GeoResolverContract;
use Modules\Analytics\Infrastructure\Geo\MaxMindGeoResolver;
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
