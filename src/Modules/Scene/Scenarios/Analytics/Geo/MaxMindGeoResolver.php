<?php

namespace Modules\Scene\Scenarios\Analytics\Geo;

use GeoIp2\Database\Reader;
use Modules\Scenarios\Analytics\Contracts\GeoResolverContract;
use Modules\Scenarios\Analytics\ValueObjects\GeoLocation;

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
