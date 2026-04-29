<?php

namespace App\Modules\Natal\Domain\VO;

final class HouseCollection
{
    /** @var array<string, House> */
    private array $items = [];

    public function __construct(House ...$houses)
    {
        foreach ($houses as $house) {
            $this->items[$house->getName()->value] = $house;
        }
    }

    public function get(string $name): House
    {
        return $this->items[$name];
    }

    /** @return array<string, House> */
    public function all(): array
    {
        return $this->items;
    }
}
