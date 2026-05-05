<?php

namespace App\Modules\Analytics\Application\UseCase;

use App\Modules\Analytics\Domain\Contracts\GeoResolverContract;
use App\Modules\Analytics\Domain\VO\GeoLocation;

final readonly class GetCountryFromIP
{
    public function __construct(
        private GeoResolverContract $resolver,
    ) {}

    public function execute(string $ip): GeoLocation
    {
        return $this->resolver->resolve($ip);
    }
}
