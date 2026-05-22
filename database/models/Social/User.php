<?php

namespace Database\Models\Social;

use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Hidden;
use WendellAdriel\Lift\Attributes\Relations\HasMany;
use WendellAdriel\Lift\Lift;

#[HasMany(UserFollow::class,         'following',             'follower_id')]
#[HasMany(UserFollow::class,         'followers',             'following_id')]
#[HasMany(UserFriend::class,         'friends',               'user_id')]
#[HasMany(UserFriendRequest::class,  'sentFriendRequests',    'sender_id')]
#[HasMany(UserFriendRequest::class,  'receivedFriendRequests','receiver_id')]
#[HasMany(UserBlock::class,          'blockedUsers',          'blocker_id')]
#[HasMany(UserBlock::class,          'blockedBy',             'blocked_id')]
final class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        Lift,
        HasRoles,
        MustVerifyEmail;

    #[Fillable]
    public ?string $name;

    #[Fillable]
    public string $email;

    #[Fillable]
    #[Hidden]
    #[Cast('hashed')]
    public string $password;

    #[Hidden]
    public ?string $remember_token = null;

    #[Cast('datetime')]
    public ?Carbon $email_verified_at;
}
