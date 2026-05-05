<?php

namespace App\Models\Social;

use WendellAdriel\Lift\Lift;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

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
