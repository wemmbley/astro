<?php

namespace App\Modules\Matrix\Domain\VO;

final readonly class BasePoints
{
    public function __construct(
        private ArcanePoint $day,
        private ArcanePoint $month,
        private ArcanePoint $year,
        private ArcanePoint $earth,
        private ArcanePoint $sky,
        private ArcanePoint $portrait,
        private ArcanePoint $talent,
        private ArcanePoint $background,
        private ArcanePoint $money,
    ) {}

    public function day(): ArcanePoint { return $this->day; }
    public function month(): ArcanePoint { return $this->month; }
    public function year(): ArcanePoint { return $this->year; }
    public function earth(): ArcanePoint { return $this->earth; }
    public function sky(): ArcanePoint { return $this->sky; }
    public function portrait(): ArcanePoint { return $this->portrait; }
    public function talent(): ArcanePoint { return $this->talent; }
    public function background(): ArcanePoint { return $this->background; }
    public function money(): ArcanePoint { return $this->money; }

    public function toArray(): array
    {
        return [
            'A (Day)'           => $this->day->getValue(),
            'B (Month)'         => $this->month->getValue(),
            'C (Year)'          => $this->year->getValue(),
            'D (Earth)'         => $this->earth->getValue(),
            'E (Sky)'           => $this->sky->getValue(),
            'F (Portrait)'      => $this->portrait->getValue(),
            'G (Talents)'       => $this->talent->getValue(),
            'H (Background)'    => $this->background->getValue(),
            'I (Money)'         => $this->money->getValue(),
        ];
    }
}
