<?php

namespace Modules\Scene\Scenarios\Natal\Http\PyClient;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Scenarios\Natal\ValueObjects\Birthday;
use Modules\Scenarios\Natal\ValueObjects\Natal;

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
                    config('services.python.host').'/chart/data',
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

    public function getNatalCircleSvg(Birthday $birthday)
    {
        try {
            $response = Http::retry(
                3,
                1000
            )
                ->timeout(10)
                ->post(
                    config('services.python.host').'/chart/svg',
                    [
                        'birth_datetime' => $birthday->getBirthDateTime(),
                        'lat' => $birthday->getLat(),
                        'lon' => $birthday->getLon(),
                    ]
                );

            $response->throw();

            $natalSvgResponse = $response->json();

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

        return $natalSvgResponse['chart_svg'];
    }
}
