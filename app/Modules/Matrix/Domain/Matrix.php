<?php

namespace App\Modules\Matrix\Domain;

use App\Modules\Matrix\Domain\Calculators\BasePointsCalculator;
use App\Modules\Matrix\Domain\Calculators\DiagonalPointsCalculator;
use App\Modules\Matrix\Domain\Fabric\ChakrasCalculatorFactory;
use App\Modules\Matrix\Domain\VO\Birthday;
use App\Modules\Matrix\Domain\VO\MatrixAggregate;

class Matrix
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function calculate(): MatrixAggregate
    {
        $basePoints = new BasePointsCalculator($this->birthday)->calculate();
        $diagonalPoints = new DiagonalPointsCalculator($this->birthday)->calculate();
        $chakrasService = ChakrasCalculatorFactory::create(
            $basePoints,
            $diagonalPoints,
        );
        $chakrasBag = $chakrasService->calculateAll();

        return new MatrixAggregate($basePoints, $diagonalPoints, $chakrasBag);
    }
}
