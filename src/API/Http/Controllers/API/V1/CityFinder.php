<?php

namespace API\Http\Controllers\API\V1;

use Database\Models\GeoCountry;
use Illuminate\Http\JsonResponse;

final readonly class CityFinder
{
    public function find(string $query, int $page = 1): JsonResponse
    {
        $pagination = GeoCountry::query()
            ->where('name', 'like', "{$query}%")
            ->orWhere('terms', 'like', "%{$query}%")
            ->orderByDesc('population')
            ->simplePaginate(15, ['*'], 'page', $page)
            ->toArray();

        return response()->json([
            'ok' => true,
            ...$pagination
        ]);
    }
}
