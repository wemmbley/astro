<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\ValueObjects\ArcanePoint;
use Modules\Esoteric\Matrix\ValueObjects\Birthday;

final readonly class EarthCalculator
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function calculate(): ArcanePoint
    {
        $baseArcane = new BaseArcaneCalculator($this->birthday);

        $earth = $baseArcane->getDayArcane()
            ->add($baseArcane->getMonthArcane())
            ->add($baseArcane->getYearArcane());

        return $earth;
    }
}
