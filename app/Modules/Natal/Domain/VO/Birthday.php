<?php

namespace App\Modules\Natal\Domain\VO;

final class Birthday
{
    private float $lat;
    private float $lon;
    private int $day;
    private int $month;
    private int $year;
    private int $hour;
    private int $minute;

    public function fromRoute(
        float $lat,
        float $lon,
        string $date,
        string $time,
    ): self
    {
        [$day, $month, $year] = explode('-', $date);
        [$hour, $minute] = explode('-', $time);

        $this->lat = $lat;
        $this->lon = $lon;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->validate();

        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLon(): float
    {
        return $this->lon;
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

    public function getHour(): int
    {
        return $this->hour;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;
        return $this;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;
        return $this;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function setHour(int $hour): self
    {
        $this->hour = $hour;
        return $this;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;
        return $this;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;
        return $this;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;
        return $this;
    }

    public function getBirthDateTime(): string
    {
        return sprintf('%02d-%02d-%04d %02d:%02d',
            $this->day,
            $this->month,
            $this->year,
            $this->hour,
            $this->minute
        );
    }

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
            'day' => $this->day,
            'month' => $this->month,
            'year' => $this->year,
            'hour' => $this->hour,
            'minute' => $this->minute,
        ];
    }

    private function validate(): void
    {
        if($this->lat < -90 || $this->lat > 90) {
            throw new \InvalidArgumentException('Invalid lat handed.');
        }

        if($this->lon < -180 || $this->lon > 180) {
            throw new \InvalidArgumentException('Invalid lon handed.');
        }

        if($this->day < 1 || $this->day > 31) {
            throw new \InvalidArgumentException('Invalid day handed.');
        }

        if($this->month < 1 || $this->month > 12) {
            throw new \InvalidArgumentException('Invalid month handed.');
        }

        if($this->year < 0) {
            throw new \InvalidArgumentException('Invalid year handed.');
        }

        if($this->hour < 0 || $this->hour > 23) {
            throw new \InvalidArgumentException('Invalid hour handed.');
        }

        if($this->minute < 0 || $this->minute > 59) {
            throw new \InvalidArgumentException('Invalid minute handed.');
        }
    }
}
