<?php

namespace App\Modules\Matrix\Application\Services;

use App\Modules\Matrix\Domain\Calculators\AjnaCalculator;
use App\Modules\Matrix\Domain\Calculators\AnahataCalculator;
use App\Modules\Matrix\Domain\Calculators\ManipuraCalculator;
use App\Modules\Matrix\Domain\Calculators\MuladharaCalculator;
use App\Modules\Matrix\Domain\Calculators\SahasraraCalculator;
use App\Modules\Matrix\Domain\Calculators\SvadhisthanaCalculator;
use App\Modules\Matrix\Domain\Calculators\VishuddhaCalculator;
use App\Modules\Matrix\Domain\VO\ChakrasBag;

final readonly class ChakrasCalculator
{
    public function __construct(
        private MuladharaCalculator $muladharaCalc,
        private SvadhisthanaCalculator $svadhisthanaCalc,
        private ManipuraCalculator $manipuraCalc,
        private AnahataCalculator $anahataCalc,
        private VishuddhaCalculator $vishuddhaCalc,
        private AjnaCalculator $ajnaCalc,
        private SahasraraCalculator $sahasraraCalc,
    ) {}

    public function calculateAll(): ChakrasBag
    {
        return new ChakrasBag(
            $this->muladharaCalc->calculate(),
            $this->svadhisthanaCalc->calculate(),
            $this->manipuraCalc->calculate(),
            $this->anahataCalc->calculate(),
            $this->vishuddhaCalc->calculate(),
            $this->ajnaCalc->calculate(),
            $this->sahasraraCalc->calculate(),
        );
    }
}
