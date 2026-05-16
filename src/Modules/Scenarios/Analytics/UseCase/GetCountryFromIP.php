<?php

namespace Modules\Business\Analytics\UseCase;

use Modules\Business\Analytics\Contracts\GeoResolverContract;
use Modules\Business\Analytics\ValueObjects\GeoLocation;

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
