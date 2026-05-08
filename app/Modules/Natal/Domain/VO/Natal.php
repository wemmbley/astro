<?php

namespace App\Modules\Natal\Domain\VO;

use App\Modules\Natal\Domain\Enums\HouseSystemName;

final readonly class Natal
{
    public function __construct(
        public PlanetCollection $planets,
        public HouseCollection  $houses,
        public Elements         $elements,
        public DominantSign     $dominantSign,
        public HouseSystemName  $houseSystem,
        public ?string          $svgChart,
    ) {}

    public function toArray(): array
    {
        return [
            'planets'       => array_map(fn(Planet $p) => $p->toArray(), $this->planets->all()),
            'cusps'         => array_map(fn(House $c) => $c->toArray(), $this->houses->all()),
            'elements'      => $this->elements->toArray(),
            'dominant_sign' => $this->dominantSign->toArray(),
            'house_system'  => $this->houseSystem->value,
            'svg_chart'     => $this->svgChart,
        ];
    }
}
