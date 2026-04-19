<?php

namespace app\Modules\Geo\Infrastructure\Console\Commands;

use app\Modules\Geo\Application\UseCases\ImportGeoCountries;
use Illuminate\Console\Command;

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
