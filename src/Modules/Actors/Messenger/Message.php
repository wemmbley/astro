<?php

namespace Modules\Actors\Messenger;

final readonly class Message
{
    public function __construct(
        private int     $id,
        private int     $authorId,
        private string  $text,
        private ?string $createdAt,
        private ?string $readAt,
    ) {}

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'authorId'  => $this->authorId,
            'text'      => $this->text,
            'createdAt' => $this->createdAt,
            'readAt'    => $this->readAt,
        ];
    }
}
