<?php

// use php importer.php UA/RU/BY

$root = dirname(__DIR__, 4); // подняться на 4 уровня до /var/www/astroslick.com/public

require_once $root . '/vendor/autoload.php';

$country = $argv[1];

$pdo = new \App\Infrastructure\DB();

$tableName = 'countries_' . strtolower($country);

$migrationsRaw = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '../database' . DIRECTORY_SEPARATOR . 'migrate_countries.sql');
$pdo->query($migrationsRaw);

$fileStream = fopen(__DIR__ . DIRECTORY_SEPARATOR . '../data' . DIRECTORY_SEPARATOR . strtoupper($country) . '.txt', 'r');

if(!$fileStream) {
    die('Something went front while file opening');
}

$rowLimit = 0;

$countryInsertSqlStart = "INSERT INTO $tableName (name, terms, lat, lon, population, timezone, country_code) VALUES ";
$countryInsertSqlMiddle = '';
$countryInsertSqlEnd = ";";

$queriesChunks = [];

while($line = fgets($fileStream, 800)) {
    $rowLimit++;

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
    ] = explode("\t", $line);

    if(empty($name) || empty($alternateNames)) {
        continue;
    }

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        continue;
    }

    if(empty($latitude) || empty($longitude)) {
        continue;
    }

    $countryInsertSqlMiddle .= sprintf("(%s,%s,%s,%s,%s,%s,%s),",
        $pdo->prepareString($name),
        $pdo->prepareString($alternateNames),
        $pdo->prepareString($latitude),
        $pdo->prepareString($longitude),
        $pdo->prepareString($population),
        $pdo->prepareString($timezone),
        $pdo->prepareString($countryCode),
    );

    $massCountryInsertRawSql = $countryInsertSqlStart . $countryInsertSqlMiddle . $countryInsertSqlEnd;

    if($rowLimit%100) {
        continue;
    }

    $countryInsertSqlMiddle = rtrim($countryInsertSqlMiddle, ',');
    $massCountryInsertRawSql = $countryInsertSqlStart . $countryInsertSqlMiddle . $countryInsertSqlEnd;
    $queriesChunks[] = $massCountryInsertRawSql;
    $countryInsertSqlMiddle = '';
}

foreach ($queriesChunks as $query) {
    $pdo->query($query);
}

fclose($fileStream);

$pdo = null;