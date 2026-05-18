<?php

namespace Modules\Actors\Astrology\ValueObjects;

use Modules\Actors\Astrology\Containers\AspectContainer;
use Modules\Actors\Astrology\Types\HouseType;
use Modules\Actors\Astrology\Types\SignType;

final readonly class House
{
    public function __construct(
        public HouseType        $house,
        public SignType         $sign,
        public AspectContainer  $aspects,
        public float            $degree,
        public string           $degreeFormatted,
        public float            $longitude,
    ) {}

    public function getName(): HouseType
    {
        return $this->house;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            house:              HouseType::from($data['house']),
            sign:               SignType::from($data['sign']),
            aspects:            $data['aspects'],
            degree:             (float) $data['degree'],
            degreeFormatted:    (string) $data['degreeFormatted'],
            longitude:          (float) $data['longitude'],
        );
    }

    public function formatDegree(): string
    {
        $deg = (int) $this->degree;
        $min = (int) round(($this->degree - $deg) * 60);

        return sprintf("%d°%02d'", $deg, $min);
    }

    public function toArray(): array
    {
        return [
            'house'             => $this->house->value,
            'sign'              => $this->sign->value,
            'degree'            => $this->degree,
            'degreeFormatted'   => $this->degreeFormatted,
            'longitude'         => $this->longitude,
        ];
    }
}
