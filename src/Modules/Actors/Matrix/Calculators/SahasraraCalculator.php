<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\DTO\Chakras\Sahasrara;
use Modules\Actors\Matrix\ValueObjects\BasePoints;

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
