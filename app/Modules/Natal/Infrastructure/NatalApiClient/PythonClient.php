<?php

namespace App\Modules\Natal\Infrastructure\NatalApiClient;

use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Domain\VO\Natal;
use Illuminate\Support\Facades\Http;

class PythonClient
{
    public function getNatalChart(Birthday $birthday): Natal
    {
        $response = Http::post(
            config('services.python.host') . '/chart',
            [
                'birth_datetime' => $birthday->getBirthDateTime(),
                'lat' => $birthday->getLat(),
                'lon' => $birthday->getLon(),
            ]
        );

        $natalChartArray = $response->json();

        return PythonResponseMapper::map($natalChartArray);
    }
}
