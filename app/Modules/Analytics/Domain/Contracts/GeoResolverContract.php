<?php

namespace App\Modules\Analytics\Domain\Contracts;

use App\Modules\Analytics\Domain\VO\GeoLocation;

interface GeoResolverContract
{
    public function resolve(string $ip): GeoLocation;
}
