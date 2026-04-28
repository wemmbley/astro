<?php

namespace App\Modules\AI\Infrastructure\Drivers\Gemini;

use App\Modules\AI\Domain\Enums\AIRequestMode;

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
