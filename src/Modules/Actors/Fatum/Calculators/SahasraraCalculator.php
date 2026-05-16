<?php

namespace Modules\Esoteric\Matrix\Calculators;

use Modules\Esoteric\Matrix\DTO\Chakras\Sahasrara;
use Modules\Esoteric\Matrix\ValueObjects\BasePoints;

final readonly class SahasraraCalculator
{
    public function __construct(
        private BasePoints $base,
    ) {}

    public function calculate(): Sahasrara
    {
        $physics = $this->base->day();
        $energy  = $this->base->month();
        $emotion = $physics->add($energy);

        return new Sahasrara(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
