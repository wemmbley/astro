<?php

namespace Modules\Scene\Scenarios\Matrix;

use Database\Models\Interpretations\InterpretEntity;
use Illuminate\Database\Eloquent\Collection;

class GetArcaneDescription
{
    public function __invoke(int $arcaneNumber): Collection
    {
        return
            InterpretEntity::query()
            ->where('name', $arcaneNumber)
            ->where('type', 'arcane')
            ->get('content');
    }
}
