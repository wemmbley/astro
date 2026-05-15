<?php

namespace Modules\Matrix\Domain\Calculators;

use Modules\Matrix\Domain\Calculators\BaseArcaneCalculator;
use Modules\Matrix\Domain\VO\ArcanePoint;
use Modules\Matrix\Domain\VO\Birthday;

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
