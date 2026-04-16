<?php

namespace App\Domain\Natal\VO;

use App\Domain\Natal\Enums\HouseName;
use App\Domain\Natal\Enums\PlanetName;
use App\Domain\Natal\Enums\SignName;

final readonly class Planet
{
    public function __construct(
        public PlanetName $name,
        public SignName $sign,
        public HouseName $house,
        public float $longitude,
        public float $degree,
        public bool $retrograde,
    ) {}

    public function getName(): PlanetName
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name:       PlanetName::from($data['name']),
            sign:       SignName::from($data['sign']),
            house:      HouseName::from($data['house']),
            longitude:  (float) $data['longitude'],
            degree:     (float) $data['degree'],
            retrograde: (bool) ($data['retrograde'] ?? false),
        );
    }

    public function isRetrograde(): bool
    {
        return $this->retrograde;
    }

    public function equals(self $other): bool
    {
        return $this->name === $other->name
            && $this->sign === $other->sign
            && $this->house === $other->house
            && abs($this->longitude - $other->longitude) < 0.001;
    }

    public function toArray(): array
    {
        return [
            'name'       => $this->name->value,
            'sign'       => $this->sign->value,
            'house'      => $this->house->value,
            'longitude'  => $this->longitude,
            'degree'     => $this->degree,
            'retrograde' => $this->retrograde,
        ];
    }
}