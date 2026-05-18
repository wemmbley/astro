<?php

namespace Modules\Actors\Matrix\DTO\Chakras;

use Modules\Actors\Matrix\ValueObjects\ArcanePoint;

abstract class AbstractChakra implements Chackra
{
    public function __construct(
        private ArcanePoint $physics,
        private ArcanePoint $energy,
        private ArcanePoint $emotion,
    ) {}

    public function getPhysics(): ArcanePoint
    {
        return $this->physics;
    }

    public function getEnergy(): ArcanePoint
    {
        return $this->energy;
    }

    public function getEmotion(): ArcanePoint
    {
        return $this->emotion;
    }
}
