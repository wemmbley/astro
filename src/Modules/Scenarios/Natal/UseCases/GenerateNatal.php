<?php

namespace Modules\Scenarios\Natal\UseCases;

use Modules\Scenarios\Natal\Services\NatalCacheService;
use Modules\Scenarios\Natal\ValueObjects\Birthday;
use Modules\Scene\Scenarios\Natal\Http\PyClient\PythonClient;

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
