<?php

namespace Modules\Natal\Domain\VO;

use Natal\Domain\Enums\HouseName;
use Natal\Domain\Enums\PlanetName;
use Natal\Domain\Enums\SignName;
use Natal\Domain\VO\Aspect;
use Natal\Domain\VO\AspectCollection;

final readonly class Planet
{
    public function __construct(
        public PlanetName $name,
        public SignName $sign,
        public HouseName $house,
        public AspectCollection $aspects,
        public float $longitude,
        public float $degree,
        public string $degreeFormatted,
        public bool $retrograde,
        public bool $stationary,
    ) {}

    public function getName(): PlanetName
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name:               PlanetName::from($data['name']),
            sign:               SignName::from($data['sign']),
            house:              HouseName::from($data['house']),
            aspects:            $data['aspects'],
            longitude:          (float) $data['longitude'],
            degree:             (float) $data['degree'],
            degreeFormatted:    $data['degreeFormatted'],
            retrograde:         (bool) ($data['retrograde'] ?? false),
            stationary:         ($data['motion'] === 'stationary' ?? false),
        );
    }

    public function isRetrograde(): bool
    {
        return $this->retrograde;
    }

    public function isStationary(): bool
    {
        return $this->stationary;
    }

    public function getDegreeFormatted(): string
    {
        return $this->degreeFormatted;
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
            'name'              => $this->name->value,
            'sign'              => $this->sign->value,
            'house'             => $this->house->value,
            'longitude'         => $this->longitude,
            'degree'            => $this->degree,
            'degreeFormatted'   => $this->degreeFormatted,
            'stationary'        => $this->stationary,
            'retrograde'        => $this->retrograde,
            'aspects'           => array_map(fn(Aspect $asp) => $asp->toArray(), $this->aspects->all())
        ];
    }
}
