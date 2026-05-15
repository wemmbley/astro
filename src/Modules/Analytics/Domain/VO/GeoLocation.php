<?php

namespace Modules\Analytics\Domain\VO;

final readonly class GeoLocation
{
    public function __construct(
        public ?string $country,
        public ?string $city,
    ) {}

    public function toArray(): array
    {
        return [
            'country' => $this->country,
            'city'    => $this->city,
        ];
    }
}
