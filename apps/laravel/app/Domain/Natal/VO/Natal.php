<?php

namespace App\Domain\Natal\ValueObjects;

use App\Domain\Natal\Enums\HouseSystemName;
use App\Domain\Natal\Enums\SignName;
use App\Domain\Natal\VO\Planet;
use App\Domain\Natal\VO\PlanetCollection;

final readonly class Natal
{
    public function __construct(
        public PlanetCollection $planets,
        public HouseCollection  $houses,
        public Elements         $elements,
        public SignName         $dominantSign,
        public HouseSystemName  $houseSystem,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'planets'       => array_map(fn(Planet $p) => $p->toArray(), $this->planets->all()),
            'cusps'         => array_map(fn(House $c) => $c->toArray(), $this->houses->all()),
            'elements'      => $this->elements->toArray(),
            'dominant_sign' => $this->dominantSign->value,
            'house_system'  => $this->houseSystem,
        ];
    }
}