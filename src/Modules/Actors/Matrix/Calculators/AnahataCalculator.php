<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\DTO\Chakras\Anahata;
use Modules\Actors\Matrix\ValueObjects\BasePoints;
use Modules\Actors\Matrix\ValueObjects\DiagonalPoints;

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
