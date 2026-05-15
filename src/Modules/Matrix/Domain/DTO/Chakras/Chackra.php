<?php

namespace Modules\Matrix\Domain\DTO\Chakras;

use Modules\Matrix\Domain\VO\ArcanePoint;

interface Chackra
{
    public function getPhysics(): ArcanePoint;
    public function getEnergy(): ArcanePoint;
    public function getEmotion(): ArcanePoint;
}
