<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Actors\Matrix\Matrix;
use Modules\Actors\Matrix\ValueObjects\Birthday;

final readonly class MatrixController
{
    public function index(): Response
    {
        seo()->title('Натальный Карта Матрица Судьбы Астросик Онлайн.');

        return Inertia::render('Matrix', []);
    }

    public function single(): Response
    {
        $date = (string) request('date');

        [$day, $month, $year] = explode('-', $date);

        $birthday = new Birthday(
            day: $day,
            month: $month,
            year: $year
        );

        $matrix = new Matrix($birthday);

        return Inertia::render('MatrixSingle', [
            ...$matrix->calculate()->toArray(),
        ]);
    }
}
