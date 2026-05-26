<?php
namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Relations\HasMany;
use WendellAdriel\Lift\Lift;

#[HasMany(UserDialogueParticipant::class, 'participants', 'dialogue_id')]
#[HasMany(UserDialogueMessage::class,     'messages',     'dialogue_id')]
final class UserDialogue extends Model
{
    use Lift;

    #[Cast('immutable_datetime')]
    public $created_at;

    #[Cast('immutable_datetime')]
    public $updated_at;

    public function lastMessage(): HasOne
    {
        return $this
            ->hasOne(UserDialogueMessage::class, 'dialogue_id')
            ->latestOfMany('created_at');
    }
}
