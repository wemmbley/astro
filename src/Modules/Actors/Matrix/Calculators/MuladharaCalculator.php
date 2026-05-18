<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\DTO\Chakras\Muladhara;
use Modules\Actors\Matrix\ValueObjects\BasePoints;

final readonly class MuladharaCalculator
{
    public function __construct(
        private BasePoints $basePoints,
    ) {}

    public function calculate(): Muladhara
    {
        $physics = $this->basePoints->year();
        $energy  = $this->basePoints->earth();
        $emotion = $this->basePoints->year()
            ->add($this->basePoints->earth());

        return new Muladhara(
            physics: $physics,
            energy:  $energy,
            emotion: $emotion,
        );
    }
}
