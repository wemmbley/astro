<?php

namespace Modules\Esoteric\Matrix\Services;

use Modules\Esoteric\Matrix\Calculators\AjnaCalculator;
use Modules\Esoteric\Matrix\Calculators\AnahataCalculator;
use Modules\Esoteric\Matrix\Calculators\ManipuraCalculator;
use Modules\Esoteric\Matrix\Calculators\MuladharaCalculator;
use Modules\Esoteric\Matrix\Calculators\SahasraraCalculator;
use Modules\Esoteric\Matrix\Calculators\SvadhisthanaCalculator;
use Modules\Esoteric\Matrix\Calculators\VishuddhaCalculator;
use Modules\Esoteric\Matrix\ValueObjects\ChakrasBag;

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
