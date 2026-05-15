<?php

namespace Modules\Analytics\Application\UseCase;

use Modules\Analytics\Domain\Contracts\GeoResolverContract;
use Modules\Analytics\Domain\VO\GeoLocation;

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
