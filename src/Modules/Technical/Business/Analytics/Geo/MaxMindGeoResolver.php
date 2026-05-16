<?php

namespace Modules\Technical\Business\Analytics\Geo;

use GeoIp2\Database\Reader;
use Modules\Business\Analytics\Contracts\GeoResolverContract;
use Modules\Business\Analytics\ValueObjects\GeoLocation;

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
