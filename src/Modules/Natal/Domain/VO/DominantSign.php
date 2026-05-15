<?php

namespace Modules\Natal\Domain\VO;

use Natal\Domain\Enums\SignName;

final readonly class DominantSign
{
    public function __construct(
        private SignName $signName,
        private int      $count,
    ) {}

    public function getSignName(): SignName
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
