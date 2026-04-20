<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\VO\ArcanePoint;
use App\Modules\Matrix\Domain\VO\Birthday;

final readonly class BaseArcaneCalculator
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function getDayArcane(): ArcanePoint
    {
        return ArcanePoint::fromInt($this->birthday->getDay());
    }

    public function getMonthArcane(): ArcanePoint
    {
        return ArcanePoint::fromInt($this->birthday->getMonth());
    }

    public function getYearArcane(): ArcanePoint
    {
        return ArcanePoint::fromInt(
            array_sum(str_split((string)$this->birthday->getYear()))
        );
    }
}
