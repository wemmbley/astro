<?php

namespace Modules\Esoteric\Matrix;

use Modules\Esoteric\Matrix\Calculators\BasePointsCalculator;
use Modules\Esoteric\Matrix\Calculators\DiagonalPointsCalculator;
use Modules\Esoteric\Matrix\Fabric\ChakrasCalculatorFactory;
use Modules\Esoteric\Matrix\ValueObjects\Birthday;
use Modules\Esoteric\Matrix\ValueObjects\MatrixAggregate;

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
