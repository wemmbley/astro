<?php

namespace App\Domain\Geo;

use App\Infrastructure\DB;

class Geo
{
    private DB $pdo;

    public function __construct(string $country = 'UA')
    {
        $this->pdo = new DB();
    }

    public function find(string $term, int $limit = -1, int $offset = 0): array
    {
        $query = "SELECT * FROM countries_ua WHERE LOWER(terms) LIKE ?";

        if ($limit !== -1) {
            $query .= ' LIMIT ' . $limit;

            if ($offset > 0) {
                $query .= ' OFFSET ' . $offset;
            }
        } else if ($offset > 0) {
            $query .= ' LIMIT 18446744073709551615 OFFSET ' . $offset;
        }

        $searchTerm = '%' . mb_strtolower($term, 'UTF-8') . '%';
        $citiesArray = $this->pdo->query($query, [$searchTerm]);

        $wrappedCitiesArray = [];
        foreach ($citiesArray as $city) {
            $wrappedCitiesArray[] = new City(
                $city->id,
                $city->name,
                $city->terms,
                $city->lat,
                $city->lon,
                $city->population,
                $city->timezone,
                $city->country_code
            );
        }

        return $wrappedCitiesArray;
    }
}