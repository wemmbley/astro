<?php

namespace UI\App\Controllers\Auth;

use Inertia\Inertia;
use Modules\Common\Infrastructure\Repositories\NavbarRepository;

final readonly class AuthWebController
{
    public function __construct(
        private NavbarRepository $navbar,
    ) {}

    public function auth()
    {
        return Inertia::render('Auth/Authorization', [
            'navbar' => $this->navbar->getByName(NavbarRepository::MAIN_NAVBAR),
        ]);
    }

    public function reg()
    {
        return Inertia::render('Auth/Registration', [
            'navbar' => $this->navbar->getByName(NavbarRepository::MAIN_NAVBAR),
        ]);
    }
}
