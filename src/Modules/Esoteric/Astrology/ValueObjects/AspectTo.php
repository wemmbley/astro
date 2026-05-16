<?php

namespace Modules\Esoteric\Astrology\ValueObjects;

use Modules\Natal\Domain\Dictionary\HouseName;
use Modules\Natal\Domain\Dictionary\PlanetName;

final readonly class AspectTo
{
    public function __construct(
        public PlanetName|HouseName $value
    ) {}

    public function isPlanet(): bool
    {
        return $this->value instanceof PlanetName;
    }

    public function isHouse(): bool
    {
        return $this->value instanceof HouseName;
    }

    public function get(): HouseName|PlanetName
    {
        return $this->value;
    }
}
