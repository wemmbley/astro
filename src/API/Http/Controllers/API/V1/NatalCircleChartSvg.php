<?php

namespace API\Http\Controllers\API\V1;

use Modules\Scenarios\Natal\ValueObjects\Birthday;
use Modules\Scene\Scenarios\Natal\Http\PyClient\PythonClient;

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
