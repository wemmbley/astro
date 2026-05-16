<?php

namespace Modules\Business\AI\ValueObjects;

final readonly class MessageBag
{
    private array $messages;

    public function __construct(
        Message ...$messages,
    ) {
        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getLastMessage(): Message
    {
        $lastMessage = array_last($this->messages);

        if(empty($lastMessage)) {
            throw new \RuntimeException('Message VO is empty');
        }

        return $lastMessage;
    }
}
