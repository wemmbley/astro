<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Infrastructure\NatalApiClient\PythonClient;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Http;

class NatalController
{
    public function index(GetNavbar $navbar): Response
    {
        return Inertia::render('Natal', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }

    public function single(PythonClient $pythonClient, GetNavbar $navbar)
    {
        $birthday = new Birthday()->fromRoute(
            lat: (float) request('lat'),
            lon: (float) request('lon'),
            date: (string) request('date'),
            time: (string) request('time'),
        );

        $natal = $pythonClient->getNatalChart($birthday);

        dd($natal);

        return Inertia::render('NatalSingle', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
