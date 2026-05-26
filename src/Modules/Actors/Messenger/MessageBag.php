<?php

namespace Modules\Actors\Messenger;

final readonly class MessageBag
{
    /** @param Message[] $messages */
    public function __construct(
        private array $messages,
    ) {}

    public function toArray(): array
    {
        return array_map(fn(Message $m) => $m->toArray(), $this->messages);
    }
}
