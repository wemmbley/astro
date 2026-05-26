<?php

namespace Modules\Actors\Messenger;

final readonly class Participant
{
    public function __construct(
        private int    $id,
        private string $name,
        private string $avatar,
        private string $isOnline,
    ) {}

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'avatar'   => $this->avatar,
            'isOnline' => $this->isOnline,
        ];
    }
}
