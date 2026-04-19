<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Hidden;
use WendellAdriel\Lift\Lift;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Lift;

    #[Fillable]
    public string $name;

    #[Fillable]
    public string $email;

    #[Fillable]
    #[Hidden]
    #[Cast('hashed')]
    public string $password;

    #[Hidden]
    public ?string $remember_token = null;

    #[Cast('datetime')]
    public string $email_verified_at;
}
