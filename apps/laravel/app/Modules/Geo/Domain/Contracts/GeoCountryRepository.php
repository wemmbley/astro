<?php

namespace app\Modules\Geo\Domain\Contracts;

interface GeoCountryRepository
{
    public function insertBatch(array $countries): void;
}
