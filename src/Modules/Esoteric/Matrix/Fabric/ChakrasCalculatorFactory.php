<?php

namespace Modules\Esoteric\Matrix\Fabric;

use Modules\Esoteric\Matrix\Calculators\AjnaCalculator;
use Modules\Esoteric\Matrix\Calculators\AnahataCalculator;
use Modules\Esoteric\Matrix\Calculators\ManipuraCalculator;
use Modules\Esoteric\Matrix\Calculators\MuladharaCalculator;
use Modules\Esoteric\Matrix\Calculators\SahasraraCalculator;
use Modules\Esoteric\Matrix\Calculators\SvadhisthanaCalculator;
use Modules\Esoteric\Matrix\Calculators\VishuddhaCalculator;
use Modules\Esoteric\Matrix\Services\ChakrasCalculator;
use Modules\Esoteric\Matrix\ValueObjects\BasePoints;
use Modules\Esoteric\Matrix\ValueObjects\DiagonalPoints;

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
