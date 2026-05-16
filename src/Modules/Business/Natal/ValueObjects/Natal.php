<?php

namespace Modules\Business\Natal\ValueObjects;

use Modules\Esoteric\Astrology\Containers\HouseContainer;
use Modules\Esoteric\Astrology\Containers\PlanetContainer;
use Modules\Natal\Domain\Containers\Elements;
use Modules\Natal\Domain\Dictionary\HouseSystemName;

final readonly class Natal
{
    public function __construct(
        public PlanetContainer $planets,
        public HouseContainer  $houses,
        public Elements        $elements,
        public DominantSign    $dominantSign,
        public HouseSystemName $houseSystem,
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
