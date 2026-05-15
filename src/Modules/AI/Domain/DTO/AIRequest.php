<?php

namespace Modules\AI\Domain\DTO;

use Modules\AI\Domain\Enums\AIRequestMode;
use Modules\AI\Domain\VO\MessageBag;

final readonly class AIRequest
{
    public function __construct(
        private MessageBag    $messages,
        private float         $temperature  = 1.0,
        private int           $maxTokens    = 128,
        private AIRequestMode $mode         = AIRequestMode::AI_REQUEST_MODE_REST,
    ) {}

    public function getMessages(): MessageBag
    {
        return $this->messages;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getMaxTokens(): int
    {
        return $this->maxTokens;
    }

    public function getMode(): AIRequestMode
    {
        return $this->mode;
    }
}
