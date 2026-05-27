<?php

namespace Database\Models;

use Database\Models\Social\User;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Lift;

class Notification extends Model
{
    use Lift;

    #[Fillable]
    public $id;

    #[Fillable]
    public $user_id;

    #[Fillable]
    public $label;

    #[Fillable]
    public $text;

    #[Fillable]
    public $link;

    #[Fillable]
    public $read;

    public function user() { return $this->belongsTo(User::class); }

    public function markAsRead(): void { $this->read = true; }
}
