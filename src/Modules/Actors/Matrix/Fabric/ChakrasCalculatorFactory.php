<?php

namespace Modules\Actors\Matrix\Fabric;

use Modules\Actors\Matrix\Calculators\AjnaCalculator;
use Modules\Actors\Matrix\Calculators\AnahataCalculator;
use Modules\Actors\Matrix\Calculators\ManipuraCalculator;
use Modules\Actors\Matrix\Calculators\MuladharaCalculator;
use Modules\Actors\Matrix\Calculators\SahasraraCalculator;
use Modules\Actors\Matrix\Calculators\SvadhisthanaCalculator;
use Modules\Actors\Matrix\Calculators\VishuddhaCalculator;
use Modules\Actors\Matrix\Services\ChakrasCalculator;
use Modules\Actors\Matrix\ValueObjects\BasePoints;
use Modules\Actors\Matrix\ValueObjects\DiagonalPoints;

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
