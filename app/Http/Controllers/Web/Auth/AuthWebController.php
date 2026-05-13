<?php

namespace App\Http\Controllers\Web\Auth;

use App\Application\UseCases\Landing\GetNavbar;
use Inertia\Inertia;

class AuthWebController
{
    public function __construct(
        private GetNavbar $navbar,
    ) {}

    public function auth()
    {
        return Inertia::render('Auth/Authorization', [
            'navbar' => $this->navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }

    public function reg()
    {
        return Inertia::render('Auth/Registration', [
            'navbar' => $this->navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
