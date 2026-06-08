<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Actors\Markdown\MDParser;
use Modules\Actors\Matrix\Matrix;
use Modules\Actors\Matrix\ValueObjects\Birthday;
use Modules\Actors\SEO\Seo;
use Modules\Actors\SEO\SeoSitePages;

final readonly class MatrixController
{
    public function index(MDParser $parser): Response
    {
        return Inertia::render('Matrix', [
            'seo' => Seo::get(SeoSitePages::MATRIX_HOME),
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
            'seo' => '',
            ...$matrix
        ]);
    }
}
