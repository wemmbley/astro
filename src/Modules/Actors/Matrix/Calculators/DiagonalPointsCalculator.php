<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\ValueObjects\Birthday;
use Modules\Actors\Matrix\ValueObjects\DiagonalPoints;

final readonly class DiagonalPointsCalculator
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function calculate(): DiagonalPoints
    {
        $baseArcane = new BaseArcaneCalculator($this->birthday);
        $earth = new EarthCalculator($this->birthday)->calculate();
        $sky = new SkyCalculator($this->birthday)->calculate();

        $base  = new BaseArcaneCalculator($this->birthday);
        $day   = $base->getDayArcane();
        $month = $base->getMonthArcane();
        $year  = $base->getYearArcane();
        $background = $day->add($earth);

        $k = $baseArcane->getDayArcane()->add($sky);
        $l = $day->add($background);
        $m = $month->add($sky);
        $n = $day->add($year);
        $o = $year->add($sky);
        $p = $n->add($earth);
        $r = $earth->add($sky);

        $diagonalPoints = new DiagonalPoints(
            $k, $l, $m, $n,
            $o, $p, $r,
        );

        return $diagonalPoints;
    }
}
