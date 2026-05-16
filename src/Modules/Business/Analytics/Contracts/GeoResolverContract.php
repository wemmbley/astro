<?php

namespace Modules\Business\Analytics\Contracts;

use Modules\Business\Analytics\ValueObjects\GeoLocation;

interface GeoResolverContract
{
    public function resolve(string $ip): GeoLocation;
}
