<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Scenarios\Natal\ValueObjects\Birthday;
use Modules\Scenarios\Natal\UseCases\GenerateNatal;

final readonly class NatalController
{
    public function index(): Response
    {
        return Inertia::render('Natal', []);
    }

    public function single(GenerateNatal $natal): Response
    {
        $birthday = new Birthday()->fromRoute(
            lat: (float)request('lat'),
            lon: (float)request('lon'),
            date: (string)request('date'),
            time: (string)request('time'),
        );

        return Inertia::render('NatalSingle', [
            'natal' => $natal->execute($birthday),
            'coordinates' => $birthday->toArray(),
        ]);
    }
}
