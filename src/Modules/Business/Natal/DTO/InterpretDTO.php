<?php

namespace Modules\Business\Natal\DTO;

use Database\Models\Interpretations\InterpretCuspidSign;
use Database\Models\Interpretations\InterpretEntity;
use Database\Models\Interpretations\InterpretPlanetAspect;
use Database\Models\Interpretations\InterpretPlanetHouse;
use Database\Models\Interpretations\InterpretPlanetSign;

/**
 * Перенощик моделей, чтобы не приходилось их вечно создавать.
 * Передавайте его в конструктор контейнера, чтобы зависимости автоматом прокидывались в него.
 */
final readonly class InterpretDTO
{
    public function __construct(
        private InterpretEntity       $entity,
        private InterpretPlanetSign   $planetSign,
        private InterpretPlanetHouse  $planetHouse,
        private InterpretPlanetAspect $planetAspect,
        private InterpretCuspidSign   $cuspidSign,
    ) {}

    public function getEntityInterpreterModel(): InterpretEntity
    {
        return $this->entity;
    }

    public function getPlanetSignInterpreterModel(): InterpretPlanetSign
    {
        return $this->planetSign;
    }

    public function getPlanetHouseInterpreterModel(): InterpretPlanetHouse
    {
        return $this->planetHouse;
    }

    public function getPlanetAspectInterpreterModel(): InterpretPlanetAspect
    {
        return $this->planetAspect;
    }

    public function getCuspidSignInterpreterModel(): InterpretCuspidSign
    {
        return $this->cuspidSign;
    }
}
