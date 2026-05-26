<?php

namespace Modules\Actors\Messenger;

final readonly class Dialogue
{
    /**
     * @param Participant[] $participants
     */
    public function __construct(
        private int         $id,
        private array       $participants,
        private ?Message    $lastMessage,
        private ?MessageBag $messageBag,
    ) {}

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'participants' => array_map(fn(Participant $p) => $p->toArray(), $this->participants),
            'lastMessage'  => $this->lastMessage?->toArray(),
            'messageBag'   => $this->messageBag?->toArray() ?? [],
        ];
    }
}
