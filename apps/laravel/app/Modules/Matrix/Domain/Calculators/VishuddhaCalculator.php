<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\DTO\Chakras\Vishuddha;
use App\Modules\Matrix\Domain\VO\DiagonalPoints;

final readonly class VishuddhaCalculator
{
    public function __construct(
        private readonly DiagonalPoints $diag,
    ) {}

    public function calculate(): Vishuddha
    {
        $physics = $this->diag->k();
        $energy  = $this->diag->m();
        $emotion = $physics->add($energy);

        return new Vishuddha(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
