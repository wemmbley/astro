<?php

namespace Modules\Scenarios\Geo\UseCases;

use Modules\Scenarios\Geo\Contracts\GeoCountryRepositoryContract;

class ImportGeoCountries
{
    public function __construct(
        private GeoCountryRepositoryContract $repository
    ) {}

    public function execute(string $country, string $filePath): void
    {
        $handle = fopen($filePath, 'r');

        if (!$handle) {
            throw new \RuntimeException('File open error');
        }

        $batch = [];
        $batchSize = 100;

        while ($line = fgets($handle)) {
            $data = explode("\t", $line);

            if (count($data) < 19) {
                continue;
            }

            [
                $geoNameId,
                $name,
                $asciiName,
                $alternateNames,
                $latitude,
                $longitude,
                $featureClass,
                $featureCode,
                $countryCode,
                $cc2,
                $admin1Code,
                $admin2Code,
                $admin3Code,
                $admin4Code,
                $population,
                $elevation,
                $dem,
                $timezone,
                $modificationDate,
            ] = $data;

            if (
                empty($name) ||
                empty($alternateNames) ||
                !is_numeric($latitude) ||
                !is_numeric($longitude)
            ) {
                continue;
            }

            $batch[] = [
                'name' => $name,
                'terms' => $alternateNames,
                'lat' => $latitude,
                'lon' => $longitude,
                'population' => (int)$population,
                'timezone' => $timezone,
                'country_code' => $countryCode,
            ];

            if (count($batch) >= $batchSize) {
                $this->repository->insertBatch($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->repository->insertBatch($batch);
        }

        fclose($handle);
    }
}
