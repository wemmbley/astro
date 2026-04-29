<?php

namespace App\Modules\Natal\Infrastructure\NatalApiClient;

use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Domain\VO\Natal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PythonClient
{
    public function getNatalChart(Birthday $birthday): Natal
    {
        try {
            $response = Http::retry(
                3,
                1000
            )
                ->timeout(10)
                ->post(
                    config('services.python.host').'/chart',
                    [
                        'birth_datetime' => $birthday->getBirthDateTime(),
                        'lat' => $birthday->getLat(),
                        'lon' => $birthday->getLon(),
                    ]
                );

            $response->throw();

            $natalChartArray = $response->json();

        } catch (\Throwable $e) {

            Log::critical(
                'Python natal service unavailable after 3 retries',
                [
                    'service' => 'python-natal',
                    'host' => config('services.python.host'),
                    'error' => $e->getMessage(),
                ]
            );

            throw $e;
        }

        return PythonResponseMapper::map($natalChartArray);
    }
}
