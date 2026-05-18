<?php

namespace Modules\Actors\Astrology\Containers;

use Modules\Actors\Astrology\ValueObjects\Planet;

final class PlanetContainer
{
    /** @var array<string, Planet> */
    private array $items = [];

    public function __construct(Planet ...$planets)
    {
        foreach ($planets as $planet) {
            $this->items[$planet->getName()->value] = $planet;
        }
    }

    public function get(string $name): Planet
    {
        return $this->items[$name];
    }

    /** @return array<string, Planet> */
    public function all(): array
    {
        return $this->items;
    }
}
