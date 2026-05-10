<?php

namespace App\Models\Interpretations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WendellAdriel\Lift\Attributes\DB;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

#[DB(table: 'interpret_entity')]
class InterpretEntity extends Authenticatable
{
    use HasFactory, Lift;

    #[PrimaryKey]
    public int $id;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $repository_key;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $name;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $type;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $content;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $lang;
}
