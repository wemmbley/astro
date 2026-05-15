<?php

namespace Database\Models\Social;

use Illuminate\Database\Eloquent\Model;
use Social\Domain\Enums\FriendRequestStatus;
use WendellAdriel\Lift\Attributes\Cast;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Attributes\Relations\BelongsTo;
use WendellAdriel\Lift\Attributes\Relations\HasOne;
use WendellAdriel\Lift\Attributes\Rules;
use WendellAdriel\Lift\Lift;

#[BelongsTo(User::class, 'sender',   'sender_id')]
#[BelongsTo(User::class, 'receiver', 'receiver_id')]
#[HasOne(UserFriend::class, 'friendship', 'request_id')]
final class UserFriendRequest extends Model
{
    use Lift;

    #[Fillable]
    public int $sender_id;

    #[Fillable]
    public int $receiver_id;

    #[Cast(FriendRequestStatus::class)]
    #[Fillable]
    #[Rules(['required', 'in:pending,accepted,declined,cancelled'])]
    public FriendRequestStatus $status;

    public function isPending(): bool
    {
        return $this->status === FriendRequestStatus::Pending;
    }

    public function isAccepted(): bool
    {
        return $this->status === FriendRequestStatus::Accepted;
    }
}
