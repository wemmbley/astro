<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

class GeoCountry extends Authenticatable
{
    use HasFactory, Lift;

    #[PrimaryKey]
    public int $id;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $geo;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $name;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $terms;

    #[Cast('float')]
    #[Fillable]
    public float $lat;

    #[Cast('float')]
    #[Fillable]
    public float $lon;

    #[Rules(['int'])]
    #[Fillable]
    public int $population;

    #[Rules(['string'])]
    #[Fillable]
    public string $timezone;

    #[Rules(['string'])]
    #[Fillable]
    public string $country_code;
}
