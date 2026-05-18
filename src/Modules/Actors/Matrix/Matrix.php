<?php

namespace Modules\Actors\Matrix;

use Modules\Actors\Matrix\Calculators\BasePointsCalculator;
use Modules\Actors\Matrix\Calculators\DiagonalPointsCalculator;
use Modules\Actors\Matrix\Fabric\ChakrasCalculatorFactory;
use Modules\Actors\Matrix\ValueObjects\Birthday;
use Modules\Actors\Matrix\ValueObjects\MatrixAggregate;

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
