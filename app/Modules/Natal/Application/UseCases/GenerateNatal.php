<?php

namespace App\Modules\Natal\Application\UseCases;

use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Domain\VO\Natal;
use App\Modules\Natal\Infrastructure\CacheService\NatalCacheService;
use App\Modules\Natal\Infrastructure\NatalApiClient\PythonClient;

final readonly class GenerateNatal
{
    public function __construct(
        private PythonClient $pythonClient,
        private NatalCacheService $cacheService,
    ) {}

    public function execute(Birthday $birthday): Natal
    {
        $natal = $this->cacheService->getNatalFromCache(function() use($birthday) {
            return $this->pythonClient->getNatalChart($birthday);
        });

        return $natal;
    }
}
