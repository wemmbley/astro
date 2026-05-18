<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\ValueObjects\ArcanePoint;
use Modules\Actors\Matrix\ValueObjects\Birthday;

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
