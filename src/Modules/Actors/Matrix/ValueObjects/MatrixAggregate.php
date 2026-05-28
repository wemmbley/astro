<?php

namespace Modules\Actors\Matrix\ValueObjects;

final readonly class MatrixAggregate
{
    public function __construct(
        private BasePoints $base,
        private DiagonalPoints $diagonal,
        private ChakrasBag $chakras,
    ) {}

    public function base(): BasePoints { return $this->base; }
    public function diagonal(): DiagonalPoints { return $this->diagonal; }
    public function chakras(): ChakrasBag { return $this->chakras; }

    public function karmicTail(): array
    {
        return [
            $this->base->background(),
            $this->base->talent(),
            $this->base->money(),
        ];
    }

    public function purpose(): array
    {
        return [
            $this->base->sky(),
            $this->base->earth(),
        ];
    }

    public function toArray(): array
    {
        return [
            'basePoints' => $this->base->toArray(),
            'diagonalPoints' => $this->diagonal->toArray(),
            'chakras' => $this->chakras->toArray(),
        ];
    }
}
