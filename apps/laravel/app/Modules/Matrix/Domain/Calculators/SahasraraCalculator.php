<?php

namespace App\Modules\Matrix\Domain\Calculators;

use App\Modules\Matrix\Domain\DTO\Chakras\Sahasrara;
use App\Modules\Matrix\Domain\VO\BasePoints;

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
