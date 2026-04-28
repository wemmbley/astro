<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\VO\BasePoints;
use App\Modules\Matrix\Domain\VO\Birthday;

final readonly class BasePointsCalculator
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function calculate(): BasePoints
    {
        $baseArcane = new BaseArcaneCalculator($this->birthday);
        $earth = new EarthCalculator($this->birthday)->calculate();
        $sky = new SkyCalculator($this->birthday)->calculate();

        $portrait = $baseArcane->getDayArcane()
            ->add($baseArcane->getMonthArcane());

        $talent = $baseArcane->getMonthArcane()
            ->add($baseArcane->getYearArcane());

        $background = $baseArcane->getDayArcane()
            ->add($earth);

        $basePoints = new BasePoints(
            day: $baseArcane->getDayArcane(),
            month: $baseArcane->getMonthArcane(),
            year: $baseArcane->getYearArcane(),
            earth: $earth,
            sky: $sky,
            portrait: $portrait,
            talent: $talent,
            background: $background,
            money: $earth->add($baseArcane->getYearArcane()),
        );

        return $basePoints;
    }
}
