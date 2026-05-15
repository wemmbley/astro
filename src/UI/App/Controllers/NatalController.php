<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Infrastructure\Repositories\NavbarRepository;
use Modules\Natal\Application\UseCases\GenerateNatal;
use Modules\Natal\Domain\VO\Birthday;

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
