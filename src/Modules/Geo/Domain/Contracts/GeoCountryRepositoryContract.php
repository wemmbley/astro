<?php

namespace Modules\Geo\Domain\Contracts;

interface GeoCountryRepositoryContract
{
    public function insertBatch(array $countries): void;
}
