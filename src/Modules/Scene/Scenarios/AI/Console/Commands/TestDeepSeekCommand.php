<?php

namespace Modules\Scene\Scenarios\AI\Console\Commands;

use App\Modules\AI\Core\Contracts\AIProvider;
use Illuminate\Console\Command;

class TestDeepSeekCommand extends Command
{
    protected $signature = 'ai:deepseek {prompt=Hello}';
    protected $description = 'Test AI provider';

    public function handle(AIProvider $ai): int
    {
        $prompt = $this->argument('prompt');

        try {
            $result = $ai->generateText($prompt);

            $this->info("Response:");
            $this->line($result);

        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        return self::SUCCESS;
    }
}
