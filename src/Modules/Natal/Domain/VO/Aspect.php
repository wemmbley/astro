<?php

namespace Modules\Natal\Domain\VO;

use Modules\Natal\Domain\Enums\AspectName;

final readonly class Aspect
{
    public function __construct(
        private AspectName $name,
        private AspectTarget $target,
        private float $orb,
        private string $orbFormatted,
    ) {}

    public function getName(): AspectName
    {
        return $this->name;
    }

    public function getAspectTarget(): AspectTarget
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
