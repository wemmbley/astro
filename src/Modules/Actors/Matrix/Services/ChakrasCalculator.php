<?php

namespace Modules\Actors\Matrix\Services;

use Modules\Actors\Matrix\Calculators\AjnaCalculator;
use Modules\Actors\Matrix\Calculators\AnahataCalculator;
use Modules\Actors\Matrix\Calculators\ManipuraCalculator;
use Modules\Actors\Matrix\Calculators\MuladharaCalculator;
use Modules\Actors\Matrix\Calculators\SahasraraCalculator;
use Modules\Actors\Matrix\Calculators\SvadhisthanaCalculator;
use Modules\Actors\Matrix\Calculators\VishuddhaCalculator;
use Modules\Actors\Matrix\ValueObjects\ChakrasBag;

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
