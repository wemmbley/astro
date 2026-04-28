<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

class Navbar extends Authenticatable
{
    use HasFactory, Lift;

    #[PrimaryKey]
    public int $id;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $name;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $link;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $label;

    #[Nullable]
    #[Fillable]
    public ?string $icon;
}
