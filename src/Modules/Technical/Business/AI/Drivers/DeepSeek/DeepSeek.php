<?php

namespace Modules\Technical\Business\AI\Drivers\DeepSeek;

use Modules\Technical\Business\AI\Drivers\DeepSeek\Client\DeepSeekClient;

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
