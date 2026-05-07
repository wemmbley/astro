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
    ) {}

    public function execute(Birthday $birthday): array
    {
        $natalCacheService = new NatalCacheService($birthday);

        $natal = $natalCacheService->getNatalFromCache(function() use($birthday) {
            return $this->pythonClient->getNatalChart($birthday)->toArray();
        });

        return $natal;
    }
}
