<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\DTO\Chakras\Manipura;
use Modules\Esoteric\Matrix\ValueObjects\BasePoints;

final readonly class ManipuraCalculator
{
    public function __construct(
        private readonly BasePoints $base,
    ) {}

    public function calculate(): Manipura
    {
        $physics = $this->base->sky();
        $energy  = $this->base->sky();
        $emotion = $physics->add($energy);

        return new Manipura(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
