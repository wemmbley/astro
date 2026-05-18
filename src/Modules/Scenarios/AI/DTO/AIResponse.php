<?php

namespace Modules\Scenarios\AI\DTO;

use Modules\Scenarios\AI\ValueObjects\Message;
use Modules\Scenarios\AI\ValueObjects\MessageBag;

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
