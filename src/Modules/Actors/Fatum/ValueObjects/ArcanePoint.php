<?php

namespace Modules\Esoteric\Matrix\ValueObjects;

final readonly class ArcanePoint
{
    public function __construct(
        private int $value
    ) {
        if ($value < 1 || $value > 22) {
            throw new \InvalidArgumentException('Arcane must be between 1 and 22');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function add(self $other): self
    {
        return self::fromInt($this->value + $other->value);
    }

    public static function fromInt(int $value): self
    {
        while ($value > 22) {
            $value = array_sum(str_split((string)$value));
        }

        return new self($value);
    }
}
