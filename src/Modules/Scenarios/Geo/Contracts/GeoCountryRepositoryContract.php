<?php

namespace Modules\Scenarios\Geo\Contracts;

interface GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void;
}
