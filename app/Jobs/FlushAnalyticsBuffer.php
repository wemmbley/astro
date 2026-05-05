<?php

namespace App\Jobs;

use App\Models\Analytics\PageView;
use Illuminate\Support\Facades\Redis;

class FlushAnalyticsBuffer
{
    public function handle(): void
    {
        $raw = Redis::lrange('analytics:buffer', 0, -1);

        if (empty($raw)) return;

        Redis::del('analytics:buffer');

        $rows = collect($raw)->map(fn($item) => json_decode($item, true));

        foreach ($rows->chunk(1000) as $chunk) {
            PageView::insert($chunk->values()->all());
        }
    }
}
