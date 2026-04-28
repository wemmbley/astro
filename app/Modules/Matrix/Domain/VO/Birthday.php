<?php

namespace App\Modules\Matrix\Domain\VO;

final readonly class Birthday
{
    public function __construct(
        private int $day,
        private int $month,
        private int $year,
    ) {
        if($day < 1 || $day > 31) {
            throw new \InvalidArgumentException('Invalid day handed.');
        }

        if($month < 1 || $month > 12) {
            throw new \InvalidArgumentException('Invalid month handed.');
        }

        if($year < 0) {
            throw new \InvalidArgumentException('Invalid year handed.');
        }
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
