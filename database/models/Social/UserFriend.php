<?php

namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Column;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Lift;

#[BelongsTo(User::class,             'user',    'user_id')]
#[BelongsTo(User::class,             'friend',  'friend_id')]
#[BelongsTo(UserFriendRequest::class,'request', 'request_id')]
final class UserFriend extends Model
{
    use Lift;

    const UPDATED_AT = null;

    #[Column]
    public int $user_id;

    #[Column]
    public int $friend_id;

    #[Column]
    public int $request_id;
}
