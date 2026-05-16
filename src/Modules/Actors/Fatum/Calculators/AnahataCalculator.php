<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\DTO\Chakras\Anahata;
use Modules\Esoteric\Matrix\ValueObjects\BasePoints;
use Modules\Esoteric\Matrix\ValueObjects\DiagonalPoints;

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
