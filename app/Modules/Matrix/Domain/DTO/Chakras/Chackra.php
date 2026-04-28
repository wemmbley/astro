<?php

namespace App\Modules\Matrix\Domain\DTO\Chakras;

use App\Modules\Matrix\Domain\VO\ArcanePoint;

interface Chackra
{
    public function getPhysics(): ArcanePoint;
    public function getEnergy(): ArcanePoint;
    public function getEmotion(): ArcanePoint;
}
