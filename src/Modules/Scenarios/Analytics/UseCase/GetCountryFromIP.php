<?php

namespace Modules\Scenarios\Analytics\UseCase;

use Modules\Scenarios\Analytics\Contracts\GeoResolverContract;
use Modules\Scenarios\Analytics\ValueObjects\GeoLocation;

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
