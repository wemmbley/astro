<?php

namespace Modules\AI\Domain\VO;

final readonly class Message
{
    public function __construct(
        private string $role,
        private string $message,
    ) {}

    public function getRole(): string
    {
        return $this->role;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
