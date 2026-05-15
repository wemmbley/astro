<?php

namespace Modules\Matrix\Domain\Calculators;

use Modules\Matrix\Domain\DTO\Chakras\Muladhara;
use Modules\Matrix\Domain\DTO\Chakras\Svadhisthana;
use Modules\Matrix\Domain\VO\BasePoints;
use Modules\Matrix\Domain\VO\DiagonalPoints;

final readonly class SvadhisthanaCalculator
{
    public function __construct(
        private DiagonalPoints $diagonalPoints,
    ) {}

    public function calculate(): Svadhisthana
    {
        $physics = $this->diagonalPoints->o();
        $energy  = $this->diagonalPoints->r();
        $emotion = $physics->add($energy);

        return new Svadhisthana(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
