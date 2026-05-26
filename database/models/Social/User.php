<?php

namespace Database\Models\Social;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Hidden;
use WendellAdriel\Lift\Attributes\Relations\HasMany;
use WendellAdriel\Lift\Attributes\Relations\HasManyThrough;
use WendellAdriel\Lift\Lift;

#[HasMany(UserFollow::class,              'following',              'follower_id')]
#[HasMany(UserFollow::class,              'followers',              'following_id')]
#[HasMany(UserFriend::class,              'friends',                'user_id')]
#[HasMany(UserFriendRequest::class,       'sentFriendRequests',     'sender_id')]
#[HasMany(UserFriendRequest::class,       'receivedFriendRequests', 'receiver_id')]
#[HasMany(UserBlacklist::class,           'blockedUsers',           'blocker_id')]
#[HasMany(UserBlacklist::class,           'blockedBy',              'blocked_id')]
#[HasMany(UserDialogueParticipant::class, 'dialogueParticipations', 'user_id')]
#[HasManyThrough(UserDialogue::class, UserDialogueParticipant::class, 'user_id', 'id', 'id', 'dialogue_id')]
final class User extends Authenticatable implements HasMedia
{
    use HasFactory,
        Notifiable,
        Lift,
        HasRoles,
        MustVerifyEmail,
        InteractsWithMedia;

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
    public $email_verified_at;

    #[Cast('datetime')]
    public $last_online;

    public function getOnlineStatus(): string
    {
        if (!$this->last_online) {
            return 'never';
        }

        return $this->last_online->greaterThanOrEqualTo(
            now()->subMinutes(5)
        )
            ? 'online'
            : $this->last_online->format('d.m.Y H:i');
    }
}
