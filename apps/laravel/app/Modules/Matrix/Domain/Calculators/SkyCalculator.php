<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\VO\ArcanePoint;
use App\Modules\Matrix\Domain\VO\Birthday;

final readonly class SkyCalculator
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function calculate(): ArcanePoint
    {
        $baseArcane = new BaseArcaneCalculator($this->birthday);
        $day = $baseArcane->getDayArcane();
        $month = $baseArcane->getMonthArcane();
        $year = $baseArcane->getYearArcane();
        $earth = new EarthCalculator($this->birthday)->calculate();

        $sky = $day->getValue()
            + $month->getValue()
            + $year->getValue()
            + $earth->getValue();

        $sky = ArcanePoint::fromInt($sky);

        return $sky;
    }
}
