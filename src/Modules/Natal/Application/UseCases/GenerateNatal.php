<?php

namespace Modules\Natal\Application\UseCases;

use Modules\Natal\Domain\VO\Birthday;
use Modules\Natal\Domain\VO\Natal;
use Modules\Natal\Infrastructure\CacheService\NatalCacheService;
use Modules\Natal\Infrastructure\NatalApiClient\PythonClient;

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
