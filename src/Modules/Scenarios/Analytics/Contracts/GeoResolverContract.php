<?php

namespace Modules\Scenarios\Analytics\Contracts;

use Modules\Scenarios\Analytics\ValueObjects\GeoLocation;

interface GeoResolverContract
{
    public function resolve(string $ip): GeoLocation;
}
