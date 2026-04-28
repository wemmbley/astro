<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController
{
    public function index(GetNavbar $navbar): Response
    {
        return Inertia::render('Profile', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
