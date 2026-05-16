<?php

namespace Modules\Business\AI\DTO;

use Modules\Business\AI\ValueObjects\Message;
use Modules\Business\AI\ValueObjects\MessageBag;

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
