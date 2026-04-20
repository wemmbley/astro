<?php

namespace App\Modules\Matrix\Domain\Fabric;

use App\Modules\Matrix\Application\Services\ChakrasCalculator;
use App\Modules\Matrix\Domain\Calculators\AjnaCalculator;
use App\Modules\Matrix\Domain\Calculators\AnahataCalculator;
use App\Modules\Matrix\Domain\Calculators\ManipuraCalculator;
use App\Modules\Matrix\Domain\Calculators\MuladharaCalculator;
use App\Modules\Matrix\Domain\Calculators\SahasraraCalculator;
use App\Modules\Matrix\Domain\Calculators\SvadhisthanaCalculator;
use App\Modules\Matrix\Domain\Calculators\VishuddhaCalculator;
use App\Modules\Matrix\Domain\VO\BasePoints;
use App\Modules\Matrix\Domain\VO\DiagonalPoints;

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
