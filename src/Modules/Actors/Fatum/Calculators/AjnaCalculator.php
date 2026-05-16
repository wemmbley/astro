<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\DTO\Chakras\Ajna;
use Modules\Esoteric\Matrix\ValueObjects\DiagonalPoints;

final readonly class AjnaCalculator
{
    public function __construct(
        private DiagonalPoints $diag,
    ) {}

    public function calculate(): Ajna
    {
        $physics = $this->diag->l();
        $energy  = $this->diag->n();
        $emotion = $physics->add($energy);

        return new Ajna(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
