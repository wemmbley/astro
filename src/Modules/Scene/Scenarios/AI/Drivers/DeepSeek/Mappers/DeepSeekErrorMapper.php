<?php

namespace Modules\Scene\Scenarios\AI\Drivers\DeepSeek\Mappers;

use App\Modules\AI\Core\Exceptions\AIProviderException;

class DeepSeekErrorMapper
{
    public static function map(int $code, array $body = []): AIProviderException
    {
        return match ($code) {

            400 => new AIProviderException(
                400,
                "Invalid Format",
                "Please modify your request body according to DeepSeek API Docs.",
                $body
            ),

            401 => new AIProviderException(
                401,
                "Authentication Fails",
                "Check your API key.",
                $body
            ),

            402 => new AIProviderException(
                402,
                "Insufficient Balance",
                "Top up your DeepSeek account.",
                $body
            ),

            422 => new AIProviderException(
                422,
                "Invalid Parameters",
                "Fix request parameters according to API docs.",
                $body
            ),

            429 => new AIProviderException(
                429,
                "Rate Limit Reached",
                "Slow down requests or implement retry/backoff.",
                $body
            ),

            500 => new AIProviderException(
                500,
                "Server Error",
                "Retry later or contact DeepSeek support.",
                $body
            ),

            503 => new AIProviderException(
                503,
                "Server Overloaded",
                "Retry after delay (use exponential backoff).",
                $body
            ),

            default => new AIProviderException(
                $code,
                "Unknown Error",
                "Check DeepSeek response body.",
                $body
            ),
        };
    }
}
