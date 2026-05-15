<?php

namespace Modules\Natal\Domain\VO;

use Modules\Natal\Domain\Enums\HouseSystemName;
use Modules\Natal\Domain\VO\DominantSign;
use Modules\Natal\Domain\VO\Elements;
use Modules\Natal\Domain\VO\House;
use Modules\Natal\Domain\VO\HouseCollection;
use Modules\Natal\Domain\VO\Planet;
use Modules\Natal\Domain\VO\PlanetCollection;

final readonly class Natal
{
    public function __construct(
        public PlanetCollection $planets,
        public HouseCollection  $houses,
        public Elements         $elements,
        public DominantSign     $dominantSign,
        public HouseSystemName  $houseSystem,
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
