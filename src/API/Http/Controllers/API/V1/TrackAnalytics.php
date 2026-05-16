<?php

namespace API\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Request;
use Modules\Business\Analytics\DTO\PageViewDTO;
use Modules\Business\Analytics\UseCase\TrackIntoRedis;

final readonly class TrackAnalytics
{
    public function track(Request $request, TrackIntoRedis $trackIntoRedis)
    {
        $trackIntoRedis->execute(new PageViewDTO(
            ip:          $request->ip(),
            url:         $request->input('url'),
            fingerprint: hash('sha256', $request->ip() . $request->userAgent()),
            userId:      auth()->id(),
            utmSource:   $request->input('utm_source'),
            utmMedium:   $request->input('utm_medium'),
            utmCampaign: $request->input('utm_campaign'),
        ));

        return response()->noContent();
    }
}
