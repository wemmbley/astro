<?php

namespace Modules\Matrix\Domain\Calculators;

use Modules\Matrix\Domain\DTO\Chakras\Anahata;
use Modules\Matrix\Domain\VO\BasePoints;
use Modules\Matrix\Domain\VO\DiagonalPoints;

final readonly class AnahataCalculator
{
    public function __construct(
        private BasePoints $base,
        private DiagonalPoints $diag,
    ) {}

    public function calculate(): Anahata
    {
        $physics = $this->diag->k()->add($this->base->sky());
        $energy  = $this->diag->m()->add($this->base->sky());
        $emotion = $physics->add($energy);

        return new Anahata(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
