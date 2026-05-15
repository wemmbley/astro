<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Infrastructure\Repositories\NavbarRepository;

final readonly class FeedController
{
    public function index(NavbarRepository $navbar): Response
    {
        return Inertia::render('Feed', [
            'navbar' => $navbar->getByName(NavbarRepository::MAIN_NAVBAR),
        ]);
    }
}
