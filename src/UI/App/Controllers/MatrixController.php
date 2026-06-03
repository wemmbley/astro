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
        seo()->title('Матрица Судьбы Онлайн.');

        return Inertia::render('Matrix', [
            'seo' => view('UI::Pages/SEO/Matrix')->render(),
        ]);
    }

    public function single(): Response
    {
        $date = (string) request('date');

        seo()->title('Матрица Судьбы ' . $date);

        [$day, $month, $year] = explode('-', $date);

        $birthday = new Birthday(
            day: $day,
            month: $month,
            year: $year
        );

        $matrix = new Matrix($birthday)->calculate()->toArray();

        return Inertia::render('MatrixSingle', [
            'interpretations' => [
                'arcanes' => [],
                'chakras' => [],
            ],
            'seo' => [
                'title' => '123',
                'content' => '222223',
            ],
            ...$matrix
        ]);
    }
}
