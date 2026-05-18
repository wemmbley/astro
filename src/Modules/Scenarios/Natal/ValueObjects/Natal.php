<?php

namespace Modules\Scenarios\Natal\ValueObjects;

use Modules\Actors\Astrology\Containers\ElementContainer;
use Modules\Actors\Astrology\Containers\HouseContainer;
use Modules\Actors\Astrology\Containers\PlanetContainer;
use Modules\Actors\Astrology\ValueObjects\House;
use Modules\Actors\Astrology\ValueObjects\Planet;
use Modules\Scenarios\Natal\Types\HouseSystemTypes;

final readonly class Natal
{
    public function __construct(
        public PlanetContainer   $planets,
        public HouseContainer    $houses,
        public ElementContainer  $elements,
        public DominantSign      $dominantSign,
        public HouseSystemTypes  $houseSystem,
    ) {}

    public function toArray(): array
    {
        return [
            'planets'       => array_map(fn(Planet $p) => $p->toArray(), $this->planets->all()),
            'cusps'         => array_map(fn(House $c) => $c->toArray(), $this->houses->all()),
            'elements'      => $this->elements->toArray(),
            'dominant_sign' => $this->dominantSign->toArray(),
            'house_system'  => $this->houseSystem->value,
        ];
    }
}
