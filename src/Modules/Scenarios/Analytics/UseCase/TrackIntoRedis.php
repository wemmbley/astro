<?php

namespace Modules\Scenarios\Analytics\UseCase;

use Illuminate\Support\Facades\Redis;
use Modules\Scenarios\Analytics\DTO\PageViewDTO;

final readonly class TrackIntoRedis
{
    public function __construct(
        private GetCountryFromIP $getCountryFromIP,
    ) {}

    public function execute(PageViewDTO $data): void
    {
        $geo = $this->getCountryFromIP->execute($data->ip);

        Redis::rpush('analytics:buffer', json_encode([
            'user_id'      => $data->userId,
            'url'          => $data->url,
            'fingerprint'  => $data->fingerprint,
            'country'      => $geo->country,
            'city'         => $geo->city,
            'utm_source'   => $data->utmSource,
            'utm_medium'   => $data->utmMedium,
            'utm_campaign' => $data->utmCampaign,
            'created_at'   => now()->toDateTimeString(),
        ]));
    }
}
