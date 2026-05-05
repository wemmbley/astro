<?php

namespace App\Modules\Analytics\Application\Services;

use App\Models\Analytics\PageView;
use Illuminate\Database\Eloquent\Collection;

class AnalyticsService
{
    public function getPageViewCount(string $url): int
    {
        return PageView::where('url', $url)->count();
    }

    public function getSiteUniqueVisitsToday(): int
    {
        return PageView::query()
            ->whereDate('created_at', today())
            ->distinct('fingerprint')
            ->count('fingerprint');
    }

    public function getSiteUniqueVisitsTodayByCountry(): Collection
    {
        return PageView::query()
            ->selectRaw('country, count(distinct fingerprint) as uniq')
            ->groupBy('country')
            ->get();
    }
}
