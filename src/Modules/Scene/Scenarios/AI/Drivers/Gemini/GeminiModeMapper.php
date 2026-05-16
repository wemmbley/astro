<?php

namespace Modules\Technical\Business\AI\Drivers\Gemini;

use Modules\Business\AI\Enums\AIRequestMode;

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
