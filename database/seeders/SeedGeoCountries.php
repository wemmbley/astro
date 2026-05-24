<?php

namespace Database\Seeders;

use Database\Models\GeoCountry;
use Illuminate\Database\Seeder;

class SeedGeoCountries extends Seeder
{
    public function run()
    {
        $handle = fopen(storage_path('geo/cities/cities500.txt'), 'r');
        if (!$handle) throw new \RuntimeException('File open error');

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
                GeoCountry::insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            GeoCountry::insert($batch);
        }

        fclose($handle);
    }
}
