<?php

namespace Modules\Scenarios\Natal\ValueObjects;

use Modules\Actors\Astrology\Types\SignType;

final readonly class DominantSign
{
    public function __construct(
        private SignType $signName,
        private int      $count,
    ) {}

    public function getSignName(): SignType
    {
        return $this->signName;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function toArray(): array
    {
        return [
            'sign' => $this->signName->value,
            'count' => $this->count,
        ];
    }
}
