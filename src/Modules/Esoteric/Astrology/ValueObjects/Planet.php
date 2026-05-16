<?php

namespace Modules\Esoteric\Astrology\ValueObjects;

use Modules\Natal\Domain\Dictionary\PlanetTypes;

class Planet
{
    public function __construct(
        private PlanetTypes $planetType,
    ) {}
}
