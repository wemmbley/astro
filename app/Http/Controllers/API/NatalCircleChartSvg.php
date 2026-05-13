<?php

namespace App\Http\Controllers\API;

use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Infrastructure\NatalApiClient\PythonClient;

final readonly class NatalCircleChartSvg
{
    public function generate(PythonClient $pythonClient)
    {
        $birthday = new Birthday()
            ->setYear(request()->year)
            ->setMonth(request()->month)
            ->setDay(request()->day)
            ->setHour(request()->hour)
            ->setMinute(request()->minute)
            ->setLat(request()->lat)
            ->setLon(request()->lon)
            ->setLon(request()->lon);

        return response()->json([
            'svg' => $pythonClient->getNatalCircleSvg($birthday),
        ]);
    }
}
