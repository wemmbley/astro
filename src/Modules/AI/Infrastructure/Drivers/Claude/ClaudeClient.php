<?php

namespace Modules\AI\Infrastructure\Drivers\Claude;

use app\Modules\AI\Core\Exceptions\AIProviderException;
use Illuminate\Support\Facades\Http;

class ClaudeClient
{
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
    ) {}

    public function chat(array $messages): array
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post("{$this->apiUrl}/v1/messages", [
            'model' => 'claude-opus-4-7',
            'max_tokens' => 128,
            'messages' => $messages,
        ]);

        if ($response->failed()) {
            throw new AIProviderException(
                $response->getStatusCode(),
                $response->body(),
                '',
            );
        }

        return $response->json();
    }
}
