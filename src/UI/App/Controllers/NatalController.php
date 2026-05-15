<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Infrastructure\Repositories\NavbarRepository;
use Modules\Natal\Application\UseCases\GenerateNatal;
use Modules\Natal\Domain\VO\Birthday;

final readonly class NatalController
{
    public function index(NavbarRepository $navbar): Response
    {
        return Inertia::render('Natal', [
            'navbar' => $navbar->getByName(NavbarRepository::MAIN_NAVBAR),
        ]);
    }

    public function single(GenerateNatal $natal, NavbarRepository $navbar): Response
    {
        $birthday = new Birthday()->fromRoute(
            lat: (float)request('lat'),
            lon: (float)request('lon'),
            date: (string)request('date'),
            time: (string)request('time'),
        );

        return Inertia::render('NatalSingle', [
            'navbar' => $navbar->getByName(NavbarRepository::MAIN_NAVBAR),
            'natal' => $natal->execute($birthday),
            'coordinates' => $birthday->toArray(),
        ]);
    }
}
