<?php

namespace App\Models\Social;

use WendellAdriel\Lift\Lift;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

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
