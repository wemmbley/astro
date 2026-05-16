<?php

namespace Modules\Business\Natal\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Business\Natal\ValueObjects\Birthday;

final readonly class NatalCacheService
{
    public function __construct(
        private Birthday $birthday,
    ) {}

    public function getNatalFromCache(
        callable $resolver
    ): mixed
    {
        # Skip cache on local.
        if (! app()->isProduction()) {
            return $resolver();
        }

        $key = $this->getCacheHashKey();

        return Cache::lock(
            $key.':lock',
            30
        )->block(
            5,
            function () use ($key, $resolver) {
                return Cache::rememberForever(
                    $key,
                    $resolver
                );
            }
        );
    }

    private function getCacheHashKey(): string
    {
        return sprintf(
            'natal:v%s:%s',
            $this->cacheVersion(),
            sha1(
                $this->birthday->getBirthDateTime().'|'.
                $this->birthday->getLat().'|'.
                $this->birthday->getLon()
            )
        );
    }

    private function cacheVersion(): int
    {
        return Cache::get(
            'natal_cache_version',
            1
        );
    }
}
