<?php

namespace Modules\Technical\Business\AI\Drivers\Claude;

use App\Modules\AI\Core\Contracts\AIProvider;

class Claude implements AIProvider
{
    public function __construct(
        private ClaudeClient $client
    ) {}

    public function generateText(string $prompt): string
    {
        $response = $this->client->chat([
            ['role' => 'user', 'content' => $prompt],
        ]);

        return $response ?? '';
    }
}
