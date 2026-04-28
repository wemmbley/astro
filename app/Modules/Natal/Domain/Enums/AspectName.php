<?php

namespace app\Modules\Natal\Domain\Enums;

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
