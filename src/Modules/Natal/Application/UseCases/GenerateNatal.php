<?php

namespace Modules\Natal\Application\UseCases;

use Natal\Domain\VO\Birthday;
use Natal\Domain\VO\Natal;
use Natal\Infrastructure\CacheService\NatalCacheService;
use Natal\Infrastructure\NatalApiClient\PythonClient;

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
