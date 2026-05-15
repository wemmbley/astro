<?php

namespace Modules\Analytics\Domain\Contracts;

use Modules\Analytics\Domain\VO\GeoLocation;

interface GeoResolverContract
{
    public function resolve(string $ip): GeoLocation;
}
