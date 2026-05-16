<?php

namespace Modules\Business\Natal\UseCases;

use Modules\Business\Natal\Services\NatalCacheService;
use Modules\Business\Natal\ValueObjects\Birthday;
use Modules\Technical\Business\Natal\Http\PyClient\PythonClient;

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
