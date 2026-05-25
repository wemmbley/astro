<?php

namespace UI\App\Controllers;

use Database\Models\Social\User;
use Inertia\Inertia;
use Inertia\Response;

final readonly class ProfileController
{
    public function index(int $id): Response
    {
        $user = User::query()->where('id', $id)->first();

        seo()->title('Профиль ' . $user->name);

        return Inertia::render('Profile', []);
    }
}
