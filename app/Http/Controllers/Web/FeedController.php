<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use Inertia\Inertia;
use Inertia\Response;

final readonly class FeedController
{
    public function index(GetNavbar $navbar): Response
    {
        return Inertia::render('Feed', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
