<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use Inertia\Inertia;
use Inertia\Response;

final readonly class HomeController
{
    public function index(GetNavbar $navbar): Response
    {
        return Inertia::render('Home', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
