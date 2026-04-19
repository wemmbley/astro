<?php

namespace App\Modules\AI\Application;

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
