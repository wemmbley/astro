<?php

namespace Modules\Analytics\Infrastructure\Geo;

use Modules\Analytics\Domain\Contracts\GeoResolverContract;
use Modules\Analytics\Domain\VO\GeoLocation;
use GeoIp2\Database\Reader;

final class MaxMindGeoResolver implements GeoResolverContract
{
    private Reader $reader;

    public function __construct()
    {
        $this->reader = new Reader(storage_path('app/geoip/GeoLite2-City.mmdb'));
    }

    public function resolve(string $ip): GeoLocation
    {
        try {
            $record = $this->reader->city($ip);

            return new GeoLocation(
                country: $record->country->isoCode,
                city:    $record->city->name,
            );
        } catch (\Exception) {
            return new GeoLocation(null, null);
        }
    }
}
