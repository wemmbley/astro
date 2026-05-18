<?php

namespace Modules\Scene\Scenarios\AI\Console\Commands;

use Illuminate\Console\Command;
use Modules\Scenarios\AI\Enums\AIRequestMode;
use Modules\Scenarios\AI\ValueObjects\Message;
use Modules\Scenarios\AI\ValueObjects\MessageBag;
use Modules\Scene\Scenarios\AI\Drivers\Gemini\Gemini;
use Modules\Scene\Scenarios\AI\Drivers\Gemini\GeminiModeMapper;

class TestGeminiCommand extends Command
{
    protected $signature = 'ai:gemini';
    protected $description = 'Test AI provider Claude';

    public function handle(): int
    {
        try {
            $config = config('ai.gemini');
            $client = new Gemini(
                $config['BASE_URL'],
                $config['API_KEY'],
                $config['MODEL'],
                new GeminiModeMapper(AIRequestMode::SSE)
            );

            $messages = new MessageBag(new Message(
                role: 'user',
                message: 'Привет! Расскажи в двух словах про знак Рак.',
            ));

            $this->info("Gemini Test");
            $this->line('─────────────────────────────');

            $client->stream($messages);

            $this->line("\n" . '─────────────────────────────');
            $this->info('Done.');

        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
        }

        return self::SUCCESS;
    }
}
