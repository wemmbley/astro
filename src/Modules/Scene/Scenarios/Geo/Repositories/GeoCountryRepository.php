<?php

namespace Modules\Scene\Scenarios\Geo\Repositories;

use Database\Models\GeoCountry;
use Modules\Scenarios\Geo\Contracts\GeoCountryRepositoryContract;

class GeoCountryRepository implements GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void
    {
        GeoCountry::insert($countries);
    }
}
