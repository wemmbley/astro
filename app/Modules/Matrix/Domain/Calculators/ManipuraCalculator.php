<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\DTO\Chakras\Manipura;
use App\Modules\Matrix\Domain\VO\BasePoints;

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
