<?php

namespace Modules\AI\Infrastructure\Drivers\DeepSeek\Client;

use Modules\AI\Infrastructure\Drivers\DeepSeek\Enums\DeepSeekTemperature;
use Modules\AI\Infrastructure\Drivers\DeepSeek\Mappers\DeepSeekErrorMapper;
use Illuminate\Support\Facades\Http;

final readonly class DeepSeekClient
{
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
    ) {}

    public function chat(array $messages, ?string $temperature = null): array
    {
        if(empty($temperature)) {
            $temperature = DeepSeekTemperature::DATA_CLEAN_ANALYSIS;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->apiUrl}/chat/completions", [
            'model' => 'deepseek-chat',
            'messages' => $messages,
            //'temperature' => $temperature,
            'stream' => false,
        ]);

        if ($response->failed()) {
            throw DeepSeekErrorMapper::map(
                $response->status(),
                $response->json()
            );
        }

        return $response->json();
    }
}
