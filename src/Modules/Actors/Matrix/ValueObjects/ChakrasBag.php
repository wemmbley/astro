<?php

namespace Modules\Actors\Matrix\ValueObjects;

use Modules\Actors\Matrix\DTO\Chakras\Ajna;
use Modules\Actors\Matrix\DTO\Chakras\Anahata;
use Modules\Actors\Matrix\DTO\Chakras\Chackra;
use Modules\Actors\Matrix\DTO\Chakras\Manipura;
use Modules\Actors\Matrix\DTO\Chakras\Muladhara;
use Modules\Actors\Matrix\DTO\Chakras\Sahasrara;
use Modules\Actors\Matrix\DTO\Chakras\Svadhisthana;
use Modules\Actors\Matrix\DTO\Chakras\Vishuddha;

final readonly class ChakrasBag
{
    public function __construct(
        public Muladhara $muladhara,
        public Svadhisthana $svadhisthana,
        public Manipura $manipura,
        public Anahata $anahata,
        public Vishuddha $vishuddha,
        public Ajna $ajna,
        public Sahasrara $sahasrara,
    ) {}

    public function all(): array
    {
        return [
            'muladhara'    => $this->muladhara,
            'svadhisthana' => $this->svadhisthana,
            'manipura'     => $this->manipura,
            'anahata'      => $this->anahata,
            'vishuddha'    => $this->vishuddha,
            'ajna'         => $this->ajna,
            'sahasrara'    => $this->sahasrara,
        ];
    }

    public function toArray(): array
    {
        return [
            1 => $this->muladhara,
            2 => $this->svadhisthana,
            3 => $this->manipura,
            4 => $this->anahata,
            5 => $this->vishuddha,
            6 => $this->ajna,
            7 => $this->sahasrara,
        ];
    }

    public function muladhara(): Muladhara
    {
        return $this->muladhara;
    }

    public function svadhisthana(): Svadhisthana
    {
        return $this->svadhisthana;
    }

    public function manipura(): Manipura
    {
        return $this->manipura;
    }

    public function anahata(): Anahata
    {
        return $this->anahata;
    }

    public function vishuddha(): Vishuddha
    {
        return $this->vishuddha;
    }

    public function ajna(): Ajna
    {
        return $this->ajna;
    }

    public function sahasrara(): Sahasrara
    {
        return $this->sahasrara;
    }

    public function byNumber(int $number): Chackra
    {
        return match ($number) {
            1 => $this->muladhara,
            2 => $this->svadhisthana,
            3 => $this->manipura,
            4 => $this->anahata,
            5 => $this->vishuddha,
            6 => $this->ajna,
            7 => $this->sahasrara,
            default => throw new \InvalidArgumentException(
                sprintf('Chakra number must be between 1 and 7, %d given', $number)
            ),
        };
    }

    public function byName(string $name): Chackra
    {
        return $this->all()[$name] ?? throw new \InvalidArgumentException(
            sprintf('Unknown chakra name: %s', $name)
        );
    }
}
