<?php

namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Lift;

#[BelongsTo(User::class, 'blocker', 'blocker_id')]
#[BelongsTo(User::class, 'blocked', 'blocked_id')]
final class UserBlock extends Model
{
    use Lift;

    const UPDATED_AT = null;

    #[Column]
    public int $blocker_id;

    #[Column]
    public int $blocked_id;
}
