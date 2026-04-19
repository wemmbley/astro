<?php

namespace app\Modules\Geo\Infrastructure\Repositories;

use App\Infrastructure\Repositories;
use app\Models\GeoCountry;
use app\Modules\Geo\Domain\Contracts\GeoCountryRepository;

class EloquentGeoCountryRepository implements GeoCountryRepository
{
    public function insertBatch(array $countries): void
    {
        GeoCountry::insert($countries);
    }
}
