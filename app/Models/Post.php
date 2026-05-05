<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\PrimaryKey;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

class Post extends Authenticatable
{
    use HasFactory, Lift;

    #[PrimaryKey]
    public int $id;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $title;

    #[Rules(['required', 'string'])]
    #[Fillable]
    public string $content;

    #[Cast('slug')]
    public string $slug;

    #[Rules(['required', 'integer', 'min:0'])]
    #[Fillable]
    public int $views_count;

    #[Rules(['required', 'integer', 'min:0'])]
    #[Fillable]
    public int $likes_count;

    #[Rules(['required', 'integer', 'min:0'])]
    #[Fillable]
    public int $comments_count;

    #[Rules(['required', 'datetime'])]
    #[Fillable]
    public string $published_at;
}
