<?php

namespace Modules\Matrix\Application\Services;

use Modules\Matrix\Domain\Calculators\AjnaCalculator;
use Modules\Matrix\Domain\Calculators\AnahataCalculator;
use Modules\Matrix\Domain\Calculators\ManipuraCalculator;
use Modules\Matrix\Domain\Calculators\MuladharaCalculator;
use Modules\Matrix\Domain\Calculators\SahasraraCalculator;
use Modules\Matrix\Domain\Calculators\SvadhisthanaCalculator;
use Modules\Matrix\Domain\Calculators\VishuddhaCalculator;
use Modules\Matrix\Domain\VO\ChakrasBag;

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
