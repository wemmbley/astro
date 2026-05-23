<?php

namespace UI\App\Controllers;

use Inertia\Response;

final readonly class MatrixController
{
    public function index(): Response
    {
        seo()->title('Натальный Карта Матрица Судьбы Астросик Онлайн.');
    }
}
