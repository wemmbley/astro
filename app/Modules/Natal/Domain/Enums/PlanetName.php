<?php

namespace App\Modules\Natal\Domain\Enums;

enum PlanetName: string
{
    case Sun = 'sun';
    case Moon = 'moon';
    case Mars = 'mars';
    case Mercury = 'mercury';
    case Venus = 'venus';
    case Jupiter = 'jupiter';
    case Saturn = 'saturn';
    case Neptune = 'neptune';
    case Uranus = 'uranus';
    case Pluto = 'pluto';
    case NorthNode = 'north_node';
    case SouthNode = 'south_node';
    case Lilith = 'lilith';
    case Chiron = 'chiron';
    case Fortune = 'fortune';
}
