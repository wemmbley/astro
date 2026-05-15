<?php

namespace Modules\Matrix\Domain\Calculators;

use Modules\Matrix\Domain\DTO\Chakras\Ajna;
use Modules\Matrix\Domain\VO\DiagonalPoints;

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
