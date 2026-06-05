<?php

namespace Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Navbar extends Model
{
    use HasFactory, HasRoles;

    public $fillable = [
        'id',
        'name',
        'link',
        'label',
        'icon'
    ];

    protected string $guard_name = 'web';
}
