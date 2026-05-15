<?php

namespace Modules\Natal\Domain\VO;

use Modules\Natal\Domain\Enums\HouseName;
use Modules\Natal\Domain\Enums\SignName;
use Modules\Natal\Domain\VO\AspectCollection;

final readonly class House
{
    public function __construct(
        public HouseName        $house,
        public SignName         $sign,
        public AspectCollection $aspects,
        public float            $degree,
        public string           $degreeFormatted,
        public float            $longitude,
    ) {}

    public function getName(): HouseName
    {
        return $this->house;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            house:              HouseName::from($data['house']),
            sign:               SignName::from($data['sign']),
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
