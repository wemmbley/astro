<?php

namespace Modules\Scene\Scenarios\AI\Drivers\DeepSeek;

use Modules\Scene\Scenarios\AI\Drivers\DeepSeek\Client\DeepSeekClient;

final readonly class DeepSeek
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
