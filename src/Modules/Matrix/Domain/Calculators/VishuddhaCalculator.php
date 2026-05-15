<?php

namespace Modules\Matrix\Domain\Calculators;

use Modules\Matrix\Domain\DTO\Chakras\Vishuddha;
use Modules\Matrix\Domain\VO\DiagonalPoints;

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
