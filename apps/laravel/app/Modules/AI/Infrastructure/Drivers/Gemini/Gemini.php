<?php

namespace App\Modules\AI\Infrastructure\Drivers\Gemini;

use App\Modules\AI\Domain\Contracts\AIClient;
use App\Modules\AI\Domain\DTO\AIRequest;
use App\Modules\AI\Domain\DTO\AIResponse;
use App\Modules\AI\Domain\Exceptions\AIProviderException;
use App\Modules\AI\Domain\VO\Message;
use App\Modules\AI\Domain\VO\MessageBag;
use App\Modules\AI\Infrastructure\Contracts\AIDriver;
use Illuminate\Support\Facades\Http;

class Gemini implements AIClient, AIDriver
{
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
        private string $model,
        private GeminiModeMapper $mode,
    ) {}

    public function generate(MessageBag $messages): string
    {
        $response = Http::withHeaders([
            'X-goog-api-key' => $this->apiKey,
            'Content-Type'   => 'application/json',
        ])->post($this->getRequestUrl(), [
            'contents' => [
                'parts' => $messages,
            ],
        ]);

        $this->validateResponse($response);

        return $response->body();
    }

    public function stream(MessageBag $messages): void
    {
        $response = Http::withHeaders([
            'X-goog-api-key' => $this->apiKey,
            'Content-Type'   => 'application/json',
        ])
            ->withOptions(['stream' => true])
            ->post($this->getRequestUrl(), $this->getGeminiRequestStructure($messages));

        $this->validateResponse($response);

        $body = $response->toPsrResponse()->getBody();
        $buffer = '';

        while (!$body->eof()) {
            $chunk = $body->read(1024);
            if (empty($chunk)) continue;

            $buffer .= $chunk;

            while (($start = strpos($buffer, '{')) !== false) {
                $level = 0;
                $end = -1;

                for ($i = $start; $i < strlen($buffer); $i++) {
                    if ($buffer[$i] === '{') $level++;
                    if ($buffer[$i] === '}') $level--;

                    if ($level === 0) {
                        $end = $i;
                        break;
                    }
                }

                if ($end === -1) break;

                $jsonStr = substr($buffer, $start, $end - $start + 1);
                $buffer = substr($buffer, $end + 1);

                $data = json_decode($jsonStr, true);

                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                if ($text !== '') {
                    echo "data: " . json_encode(['text' => $text], JSON_UNESCAPED_UNICODE) . "\n\n";

                    if (ob_get_level() > 0) ob_flush();

                    flush();
                }
            }

            if (connection_aborted()) break;
        }
    }

    public function send(AIRequest $request): AIResponse
    {
        // TODO: Implement send() method.
    }

    private function getRequestUrl(): string
    {
        $requestUrl = sprintf('%s/v1beta/models/%s:%s',
            $this->apiUrl,
            $this->model,
            $this->mode->getRequestMode()
        );

        return $requestUrl;
    }

    private function validateResponse($response)
    {
        if ($response->failed()) {
            throw new AIProviderException(
                $response->getStatusCode(),
                $response->body(),
            );
        }
    }

    private function getGeminiRequestStructure(MessageBag $messages): array
    {
        $geminiParts = array_map(function (Message $message) {
            return [
                'role'  => $message->getRole() === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $message->getMessage()]],
            ];
        }, $messages->getMessages());

        return [
            'contents' => $geminiParts,
        ];
    }
}
