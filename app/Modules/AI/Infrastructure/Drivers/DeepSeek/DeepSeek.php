<?php

namespace app\Modules\AI\Infrastructure\Drivers\DeepSeek;

use App\Modules\AI\Core\Contracts\AIProvider;
use app\Modules\AI\Infrastructure\Drivers\DeepSeek\Client\DeepSeekClient;

final readonly class DeepSeek implements AIProvider
{
    public function __construct(
        private DeepSeekClient $client
    ) {}

    public function generateText(string $prompt): string
    {
        $response = $this->client->chat([
            ['role' => 'user', 'content' => $prompt],
        ]);

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
