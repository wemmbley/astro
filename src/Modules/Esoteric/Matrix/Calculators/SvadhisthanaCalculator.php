<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\DTO\Chakras\Svadhisthana;
use Modules\Esoteric\Matrix\ValueObjects\DiagonalPoints;

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
