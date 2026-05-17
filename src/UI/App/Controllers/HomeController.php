<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class HomeController
{
    public function index(): Response
    {
        seo()->title('Натальный Расчёт Матрицы Судьбы Онлайн Бесплатно.');

        return Inertia::render('Landing', []);
    }
}
