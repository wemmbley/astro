<?php

namespace Modules\Geo\Domain\VO;

final readonly class City
{
    public function __construct(
        private int    $id,
        private string $name,
        private string $terms,
        private float  $lat,
        private float  $lot,
        private int    $population,
        private string $timezone,
        private string $countryCode,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTerms(): string
    {
        return $this->terms;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLot(): float
    {
        return $this->lot;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

}
