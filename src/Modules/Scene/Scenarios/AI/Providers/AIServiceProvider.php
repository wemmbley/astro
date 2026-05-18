<?php

namespace Modules\Scene\Scenarios\AI\Providers;

use App\Modules\AI\Adapters\Gemini\GeminiAdapter;
use App\Modules\AI\Core\Contracts\AIProvider;
use app\Modules\AI\Infrastructure\Drivers\Gemini\GeminiClient;
use Illuminate\Support\ServiceProvider;
use Modules\Scene\Scenarios\AI\Console\Commands\TestClaudeCommand;
use Modules\Scene\Scenarios\AI\Console\Commands\TestDeepSeekCommand;
use Modules\Scene\Scenarios\AI\Console\Commands\TestGeminiCommand;

class AIServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestDeepSeekCommand::class,
                TestClaudeCommand::class,
                TestGeminiCommand::class,
            ]);
        }
    }
    public function register(): void
    {
        $this->app->bind(AIProvider::class, function () {
            $config = config('ai.gemini');

            $client = new GeminiClient(
                $config['BASE_URL'],
                $config['API_KEY']
            );

            return new GeminiAdapter($client);
        });
    }
}
