<?php

namespace Modules\Business\AI;

use App\Modules\AI\Application\AIClient;
use App\Modules\AI\Application\ClaudeClient;
use App\Modules\AI\Application\GeminiClient;

class AIClientFactory
{
    public function make(string $driver): AIClient
    {
        return match ($driver) {
            'gemini' => new GeminiClient(),
            'claude' => new ClaudeClient(),
            'deepseek' => new ClaudeClient(),
        };
    }
}
