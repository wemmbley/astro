<?php

namespace Modules\Actors\Astrology\ValueObjects;

use Modules\Actors\Astrology\Types\HouseType;
use Modules\Actors\Astrology\Types\PlanetType;

final readonly class AspectTo
{
    public function __construct(
        public PlanetType|HouseType $value
    ) {}

    public function isPlanet(): bool
    {
        return $this->value instanceof PlanetType;
    }

    public function isHouse(): bool
    {
        return $this->value instanceof HouseType;
    }

    public function get(): HouseType|PlanetType
    {
        return $this->value;
    }
}
