<?php

namespace Modules\Matrix\Domain\Fabric;

use Modules\Matrix\Application\Services\ChakrasCalculator;
use Modules\Matrix\Domain\Calculators\AjnaCalculator;
use Modules\Matrix\Domain\Calculators\AnahataCalculator;
use Modules\Matrix\Domain\Calculators\ManipuraCalculator;
use Modules\Matrix\Domain\Calculators\MuladharaCalculator;
use Modules\Matrix\Domain\Calculators\SahasraraCalculator;
use Modules\Matrix\Domain\Calculators\SvadhisthanaCalculator;
use Modules\Matrix\Domain\Calculators\VishuddhaCalculator;
use Modules\Matrix\Domain\VO\BasePoints;
use Modules\Matrix\Domain\VO\DiagonalPoints;

final readonly class ChakrasCalculatorFactory
{
    public static function create(
        BasePoints $basePoints,
        DiagonalPoints $diagonalPoints
    ): ChakrasCalculator
    {
        return new ChakrasCalculator(
            muladharaCalc:    new MuladharaCalculator($basePoints),
            svadhisthanaCalc: new SvadhisthanaCalculator($diagonalPoints),
            manipuraCalc:     new ManipuraCalculator($basePoints),
            anahataCalc:      new AnahataCalculator($basePoints, $diagonalPoints),
            vishuddhaCalc:    new VishuddhaCalculator($diagonalPoints),
            ajnaCalc:         new AjnaCalculator($diagonalPoints),
            sahasraraCalc:    new SahasraraCalculator($basePoints),
        );
    }
}
