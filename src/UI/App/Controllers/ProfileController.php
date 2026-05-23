<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class ProfileController
{
    public function index(): Response
    {
        seo()->title('Профиль');

        return Inertia::render('Profile', []);
    }
}
