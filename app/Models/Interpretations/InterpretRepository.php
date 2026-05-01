<?php

namespace App\Models\Interpretations;

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
    public string $url;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $version;

    #[Fillable]
    public ?string $last_cached_date;

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->key = self::buildKey($model->name, $model->version);
        });

        static::updating(function (self $model) {
            if ($model->isDirty('name') || $model->isDirty('version')) {
                $model->key = self::buildKey($model->name, $model->version);
            }
        });
    }

    public static function buildKey(string $name, string $version): string
    {
        return Str::slug($name) . ':' . $version;
    }
}
