<?php

namespace Modules\Actors\Matrix;

use Modules\Actors\Matrix\Calculators\BasePointsCalculator;
use Modules\Actors\Matrix\Calculators\DestinyNumberCalculator;
use Modules\Actors\Matrix\Calculators\DiagonalPointsCalculator;
use Modules\Actors\Matrix\Fabric\ChakrasCalculatorFactory;
use Modules\Actors\Matrix\ValueObjects\Birthday;
use Modules\Actors\Matrix\ValueObjects\MatrixAggregate;

final readonly class Matrix
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
        $destinyNumber = new DestinyNumberCalculator($this->birthday)->calculate();

        return new MatrixAggregate($destinyNumber, $basePoints, $diagonalPoints, $chakrasBag);
    }
}
