<?php

namespace Modules\Actors\Matrix\Calculators;

use Modules\Actors\Matrix\ValueObjects\Birthday;

final readonly class DestinyNumberCalculator
{
    public function __construct(
        private Birthday $birthday
    ) {}

    public function calculate(): int
    {
        $digits = $this->extractDigits($this->birthday);

        $sum = array_sum($digits);

        return $this->reduceToSingleDigit($sum);
    }

    private function extractDigits(Birthday $birthday): array
    {
        $dateString =
            str_pad((string)$birthday->getDay(), 2, '0', STR_PAD_LEFT) .
            str_pad((string)$birthday->getMonth(), 2, '0', STR_PAD_LEFT) .
            (string)$birthday->getYear();

        return array_map('intval', str_split($dateString));
    }

    private function reduceToSingleDigit(int $number): int
    {
        while ($number > 9) {
            $number = array_sum(
                array_map('intval', str_split((string)$number))
            );
        }

        return $number;
    }
}
