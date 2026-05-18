<?php

namespace Modules\Scene\Scenarios\AI\Drivers\Gemini;

use Modules\Scenarios\AI\Enums\AIRequestMode;

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
