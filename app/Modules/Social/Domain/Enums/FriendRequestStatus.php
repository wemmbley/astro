<?php

namespace App\Modules\Social\Domain\Enums;

enum FriendRequestStatus: string
{
    case Pending   = 'pending';
    case Accepted  = 'accepted';
    case Declined  = 'declined';
    case Cancelled = 'cancelled';
}
