<?php

namespace Modules\Matrix\Domain;

use Modules\Matrix\Domain\Calculators\BasePointsCalculator;
use Modules\Matrix\Domain\Calculators\DiagonalPointsCalculator;
use Modules\Matrix\Domain\Fabric\ChakrasCalculatorFactory;
use Modules\Matrix\Domain\VO\Birthday;
use Modules\Matrix\Domain\VO\MatrixAggregate;

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
