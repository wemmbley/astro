<?php

namespace Modules\Esoteric\Matrix\DTO\Chakras;

use Modules\Esoteric\Matrix\ValueObjects\ArcanePoint;

interface Chackra
{
    public function getPhysics(): ArcanePoint;
    public function getEnergy(): ArcanePoint;
    public function getEmotion(): ArcanePoint;
}
