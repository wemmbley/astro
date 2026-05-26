<?php

namespace Modules\Scene\Scenarios\Auth\UseCases;

use Database\Models\Social\User;

class SetUserAvatar
{
    public function __invoke(User $user, ?string $avatar = null): void
    {
        $avatar = $avatar ?? match ($user->sex) {
            'f' => storage_path('public/NoAvatarWomanXS.jpg'),
            default  => storage_path('public/NoAvatarManXS.jpg'),
        };

        $user
            ->addMedia($avatar)
            ->preservingOriginal()
            ->toMediaCollection('avatar');
    }
}
