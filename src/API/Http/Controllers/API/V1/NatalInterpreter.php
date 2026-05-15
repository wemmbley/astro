<?php

namespace API\Http\Controllers\API\V1;

use Database\Models\Interpretations\InterpretEntity;
use Database\Models\Interpretations\InterpretPlanetAspect;
use Database\Models\Interpretations\InterpretPlanetHouse;
use Database\Models\Interpretations\InterpretPlanetSign;
use Illuminate\Http\JsonResponse;

final readonly class NatalInterpreter
{
    public function __construct(
        private InterpretEntity       $entity,
        private InterpretPlanetSign   $planetSign,
        private InterpretPlanetHouse  $planetHouse,
        private InterpretPlanetAspect $planetAspect,
    ) {}

    public function planet(string $planetName): JsonResponse
    {
        $sign    = request()->input('sign');
        $house   = request()->input('house');
        $aspects = request()->input('aspects');

        $repoKey     = 'default:1.0.0';
        $houseFormatted = $house ? str_pad($house, 2, '0', STR_PAD_LEFT) : null;

        // Базовое описание планеты
        $entity = $this->entity
            ->where('repository_key', $repoKey)
            ->where('type', 'planet')
            ->where('name', $planetName)
            ->value('content');

        // Планета в знаке
        $inSign = $sign
            ? $this->planetSign
                ->where('repository_key', $repoKey)
                ->where('planet', $planetName)
                ->where('sign', $sign)
                ->value('content')
            : null;

        // Планета в доме
        $inHouse = $houseFormatted
            ? $this->planetHouse
                ->where('repository_key', $repoKey)
                ->where('planet', $planetName)
                ->where('house', $houseFormatted)
                ->value('content')
            : null;

        // Аспекты планеты
        $inAspects = null;
        if (!empty($aspects)) {
            $inAspects = $this->planetAspect
                ->where('repository_key', $repoKey)
                ->where('planet', $planetName)
                ->where(function ($query) use ($aspects) {
                    foreach ($aspects as $a) {
                        $query->orWhere(function ($q) use ($a) {
                            $q->where('aspect',    $a['aspect'])
                                ->where('to_planet', $a['to_planet']);
                        });
                    }
                })
                ->get(['aspect', 'to_planet', 'content'])
                ->toArray();
        }

        return response()->json([
            'planet'   => $planetName,
            'interpret' => [
                'entity'  => $entity,
                'sign'    => $inSign,
                'house'   => $inHouse,
                'aspects' => $inAspects,
            ],
        ]);
    }
}
