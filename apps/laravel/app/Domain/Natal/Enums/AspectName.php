<?php

namespace App\Domain\Natal\Enums;

enum AspectName: string
{
    case Trine = 'trine';
    case Square = 'square';
    case Sextile = 'sextile';
    case Quintile = 'quintile';
    case Quincunx = 'quincunx';
    case Opposition = 'opposition';
    case Conjunction = 'conjunction';
    case Biquintile = 'biquintile';
}