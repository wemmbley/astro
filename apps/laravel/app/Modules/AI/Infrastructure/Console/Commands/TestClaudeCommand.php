<?php

namespace App\Modules\AI\Infrastructure\Console\Commands;

use App\Modules\AI\Core\Contracts\AIProvider;
use Illuminate\Console\Command;

class TestClaudeCommand extends Command
{
    protected $signature = 'ai:claude {prompt=Hello}';
    protected $description = 'Test AI provider Claude';

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
