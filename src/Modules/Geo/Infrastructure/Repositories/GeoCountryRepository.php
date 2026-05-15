<?php

namespace Modules\Geo\Infrastructure\Repositories;

use Database\Models\GeoCountry;
use Modules\Geo\Domain\Contracts\GeoCountryRepositoryContract;

class GeoCountryRepository implements GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void
    {
        GeoCountry::insert($countries);
    }
}
