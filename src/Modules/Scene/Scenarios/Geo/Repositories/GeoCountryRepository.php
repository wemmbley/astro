<?php

namespace Modules\Technical\Business\Geo\Repositories;

use Database\Models\GeoCountry;
use Modules\Business\Geo\Contracts\GeoCountryRepositoryContract;

class GeoCountryRepository implements GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void
    {
        GeoCountry::insert($countries);
    }
}
