<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\DTO\Chakras\Svadhisthana;
use Modules\Actors\Matrix\ValueObjects\DiagonalPoints;

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
