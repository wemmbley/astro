<?php

namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Lift;

#[BelongsTo(UserDialogue::class, 'dialogue', 'dialogue_id')]
#[BelongsTo(User::class,         'user',     'user_id')]
final class UserDialogueParticipant extends Model
{
    use Lift;

    public $timestamps = false;

    #[Fillable]
    public int $dialogue_id;

    #[Fillable]
    public int $user_id;

    public $created_at;
}
