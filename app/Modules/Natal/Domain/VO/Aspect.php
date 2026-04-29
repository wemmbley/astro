<?php

namespace App\Modules\Natal\Domain\VO;

use App\Modules\Natal\Domain\Enums\AspectName;
use App\Modules\Natal\Domain\Enums\PlanetName;

final readonly class Aspect
{
    public function __construct(
        private AspectName $name,
        private AspectTarget $target,
        private float $orb,
    ) {}

    public function getName(): AspectName
    {
        return $this->name;
    }

    public function getAspectTarget(): AspectTarget
    {
        return $this->target;
    }

    public function getOrb(): float
    {
        return $this->orb;
    }
}
