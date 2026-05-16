<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\ValueObjects\Birthday;
use Modules\Esoteric\Matrix\ValueObjects\DiagonalPoints;

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

        $k = $baseArcane->getDayArcane()->add($sky);
        $l = $baseArcane->getMonthArcane()->add($sky);
        $m = $sky->add($baseArcane->getYearArcane());
        $n = $sky->add($earth);
        $o = $m->add($n);
        $p = $n->add($earth);
        $r = $m->add($baseArcane->getYearArcane());

        $diagonalPoints = new DiagonalPoints(
            $k, $l, $m, $n,
            $o, $p, $r,
        );

        return $diagonalPoints;
    }
}
