<?php

namespace App\Http\Controllers\API;

use App\Models\Interpretations\InterpretEntity;
use Illuminate\Http\JsonResponse;

class NatalInterpreter
{
    public function __construct(
        private InterpretEntity $entity,
    ) {}

    public function planet(string $planetName): JsonResponse
    {
        $planetInterpret = $this->entity
            ->where('repository_key', 'default:1.0.0')
            ->where('type', 'planet')
            ->where('name', $planetName)
            ->value('content');

        return response()->json([
            'interpret' => $planetInterpret,
        ]);
    }
}
