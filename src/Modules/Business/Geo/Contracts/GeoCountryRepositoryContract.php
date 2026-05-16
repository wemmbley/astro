<?php

namespace Modules\Business\Geo\Contracts;

interface GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void;
}
