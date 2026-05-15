<?php

namespace Modules\AI\Domain\DTO;

use Modules\AI\Domain\VO\Message;
use Modules\AI\Domain\VO\MessageBag;

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
