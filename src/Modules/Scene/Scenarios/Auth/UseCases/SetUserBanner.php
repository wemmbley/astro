<?php

namespace Modules\Scene\Scenarios\Auth\UseCases;

use Database\Models\Social\User;

class SetUserBanner
{
    public function __invoke(User $user, ?string $banner = null): void
    {
        $banner = $banner ?? match ($user->sex) {
            'f' => storage_path('public/DefaultBannerWoman.jpg'),
            default => storage_path('public/DefaultBannerMan.jpg'),
        };

        $user
            ->addMedia($banner)
            ->preservingOriginal()
            ->toMediaCollection('banner');
    }
}
