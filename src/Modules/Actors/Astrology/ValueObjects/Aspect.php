<?php

namespace Modules\Actors\Astrology\ValueObjects;

use Modules\Actors\Astrology\Types\AspectType;

final readonly class Aspect
{
    public function __construct(
        private AspectType $name,
        private AspectTo   $target,
        private float      $orb,
        private string     $orbFormatted,
    ) {}

    public function getName(): AspectType
    {
        return $this->name;
    }

    public function getAspectTarget(): AspectTo
    {
        return $this->target;
    }

    public function getOrb(): float
    {
        return $this->orb;
    }

    public function getOrbFormatted(): string
    {
        return $this->orbFormatted;
    }

    public function toArray(): array
    {
        return [
            'name'          => $this->name->value,
            'target'        => $this->target->get()->value,
            'orb'           => $this->orb,
            'orbFormatted'  => $this->orbFormatted,
        ];
    }
}
