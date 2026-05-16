<?php

namespace Modules\Technical\Business\Geo\Console\Commands;

use Illuminate\Console\Command;
use Modules\Business\Geo\UseCases\ImportGeoCountries;

class ImportCountriesCommand extends Command
{
    protected $signature = 'countries:import {country}';
    protected $description = 'Import countries data';

    public function handle(ImportGeoCountries $useCase): int
    {
        $country = strtoupper($this->argument('country'));

        $filePath = base_path("data/{$country}.txt");

        $useCase->execute($country, $filePath);

        $this->info("Import completed: {$country}");

        return self::SUCCESS;
    }
}
