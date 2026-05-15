<?php

namespace Modules\AI\Infrastructure\Drivers\Gemini;

use Modules\AI\Domain\Enums\AIRequestMode;

class GeminiModeMapper
{
    public function __construct(
        private AIRequestMode $requestMode,
    ) {}

    public function getRequestMode(): string
    {
        return match ($this->requestMode) {
            AIRequestMode::REST => 'generateContent',
            AIRequestMode::SSE => 'streamGenerateContent',
        };
    }
}
