<?php

namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Lift;

#[BelongsTo(User::class, 'follower',  'follower_id')]
#[BelongsTo(User::class, 'following', 'following_id')]
final class UserFollow extends Model
{
    use Lift;

    const null UPDATED_AT = null;

    #[Column]
    public int $follower_id;

    #[Column]
    public int $following_id;

    #[Cast('datetime')]
    #[Column]
    public string $created_at;
}
