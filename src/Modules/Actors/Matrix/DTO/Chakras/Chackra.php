<?php

namespace Modules\Actors\Matrix\DTO\Chakras;

use Modules\Actors\Matrix\ValueObjects\ArcanePoint;

interface Chackra
{
    public function getPhysics(): ArcanePoint;
    public function getEnergy(): ArcanePoint;
    public function getEmotion(): ArcanePoint;
}
