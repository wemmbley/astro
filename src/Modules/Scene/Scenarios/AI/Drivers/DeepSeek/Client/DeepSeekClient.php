<?php

namespace Modules\Technical\Business\AI\Drivers\DeepSeek\Client;

use Illuminate\Support\Facades\Http;
use Modules\Technical\Business\AI\Drivers\DeepSeek\Enums\DeepSeekTemperature;
use Modules\Technical\Business\AI\Drivers\DeepSeek\Mappers\DeepSeekErrorMapper;

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
