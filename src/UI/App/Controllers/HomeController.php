<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class HomeController
{
    public function index(): Response
    {
        seo()->title('Натальный Карта Матрица Судьбы Астросик Онлайн.');

        return Inertia::render('Landing', []);
    }
}
