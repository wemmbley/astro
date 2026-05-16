<?php

namespace Modules\Esoteric\Astrology\Containers;

use Modules\Esoteric\Astrology\ValueObjects\House;

final class HouseContainer
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
