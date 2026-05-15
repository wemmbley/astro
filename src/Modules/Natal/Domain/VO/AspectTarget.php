<?php

namespace Modules\Natal\Domain\VO;

use Modules\Natal\Domain\Enums\HouseName;
use Modules\Natal\Domain\Enums\PlanetName;

final readonly class AspectTarget
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
