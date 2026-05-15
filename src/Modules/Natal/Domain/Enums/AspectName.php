<?php

namespace Modules\Natal\Domain\Enums;

enum AspectName: string
{
    case Trine = 'trine';
    case Square = 'square';
    case Sextile = 'sextile';
    case Quintile = 'quintile';
    case Quincunx = 'quincunx';
    case Opposition = 'opposition';
    case Parallel = 'parallel';
    case Conjunction = 'conjunction';
    case Biquintile = 'biquintile';
    case Semisquare = 'semisquare';
    case Contraparallel = 'contraparallel';
    case Semisextile = 'semisextile';
    case Sesquiquadrate = 'sesquiquadrate';
}
