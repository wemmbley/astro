<?php

namespace App\Modules\AI\Domain\DTO;

use App\Modules\AI\Domain\VO\Message;
use App\Modules\AI\Domain\VO\MessageBag;

final readonly class AIResponse
{
    public function __construct(
        private MessageBag $messages,
    ) {}

    public function getChatHistory(): MessageBag
    {
        return $this->messages;
    }

    public function getLastMessage(): Message
    {
        return $this->messages->getLastMessage();
    }

    public function isSuccessfully()
    {

    }

    public function isFailure()
    {

    }
}
