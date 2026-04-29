<?php

namespace App\Modules\Natal\Domain\VO;

final class AspectCollection
{
    /** @var array<string, Aspect> */
    private array $items = [];

    public function __construct(Aspect ...$aspects)
    {
        foreach ($aspects as $aspect) {
            $this->items[] = $aspect;
        }
    }

    /** @return array<string, Aspect> */
    public function all(): array
    {
        return $this->items;
    }
}
