<?php

namespace app\Modules\Natal\Domain\VO;

final readonly class Elements
{
    public function __construct(
        public int $fire,
        public int $earth,
        public int $air,
        public int $water,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            fire:  (int) ($data['fire'] ?? 0),
            earth: (int) ($data['earth'] ?? 0),
            air:   (int) ($data['air'] ?? 0),
            water: (int) ($data['water'] ?? 0),
        );
    }

    public function dominant(): string
    {
        $elements = [
            'fire'  => $this->fire,
            'earth' => $this->earth,
            'air'   => $this->air,
            'water' => $this->water,
        ];

        arsort($elements);

        return array_key_first($elements);
    }

    public function total(): int
    {
        return $this->fire + $this->earth + $this->air + $this->water;
    }

    public function toArray(): array
    {
        return [
            'fire'  => $this->fire,
            'earth' => $this->earth,
            'air'   => $this->air,
            'water' => $this->water,
        ];
    }
}
