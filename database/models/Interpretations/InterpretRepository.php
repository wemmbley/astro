<?php

namespace Database\Models\Interpretations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

class InterpretRepository extends Authenticatable
{
    use HasFactory, Lift;

    #[PrimaryKey]
    public int $id;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $name;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $key;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $version;

    #[Rules(['required', 'integer'])]
    #[Fillable]
    public int $stars;

    #[Fillable]
    public int $author_id;

    #[Fillable]
    public ?string $last_cached_date;

    public static function buildKey(string $name, string $version): string
    {
        return Str::slug($name) . ':' . $version;
    }
}
