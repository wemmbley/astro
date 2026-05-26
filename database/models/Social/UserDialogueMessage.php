<?php
namespace Database\Models\Social;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Lift;

#[BelongsTo(UserDialogue::class, 'dialogue', 'dialogue_id')]
#[BelongsTo(User::class,         'author',   'author_id')]
final class UserDialogueMessage extends Model
{
    use Lift;

    #[Fillable]
    public int $dialogue_id;

    #[Fillable]
    public int $author_id;

    #[Fillable]
    public string $user_message;

    #[Cast('immutable_datetime')]
    public $read_at;

    #[Cast('immutable_datetime')]
    public $created_at;

    #[Cast('immutable_datetime')]
    public $updated_at;

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
