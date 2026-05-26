<?php

namespace UI\App\Controllers;

use Database\Models\Social\UserDialogue;
use Database\Models\Social\UserDialogueParticipant;
use Modules\Actors\Messenger\Dialogue;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Actors\Messenger\Message;
use Modules\Actors\Messenger\Participant;

class MessagesController
{
    public function index(): Response
    {
        $currentUser = auth()->user();

        $lastDialogues = UserDialogue::whereHas('participants', function ($query) use ($currentUser) {
            $query->where('user_id', $currentUser->id);
        })
            ->with([
                'participants.user',
                'lastMessage.author',
            ])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        $dialogues = $lastDialogues->map(function (UserDialogue $dialogueModel) use ($currentUser) {
            $participants = $dialogueModel->participants
                ->map(fn(UserDialogueParticipant $participant) => new Participant(
                    id:       $participant->user->id,
                    name:     $participant->user->name,
                    avatar:   $participant->user->getFirstMediaUrl('avatar'),
                    isOnline: $participant->user->getOnlineStatus(),
                ))
                ->values()
                ->all();

            $lastMessage = null;

            if ($dialogueModel->lastMessage) {
                $lastModelMessage = $dialogueModel->lastMessage;

                $lastMessage = new Message(
                    id:        $lastModelMessage->id,
                    authorId:  $lastModelMessage->author_id,
                    text:      $lastModelMessage->user_message,
                    createdAt: $lastModelMessage->created_at?->format('d.m.Y H:i'),
                    readAt:    $lastModelMessage->read_at?->format('d.m.Y H:i'),
                );
            }

            return new Dialogue(
                id:           $dialogueModel->id,
                participants: $participants,
                lastMessage:  $lastMessage,
                messageBag:   null,
            );
        });

        seo()->title('Личные сообщения');

        return Inertia::render('Messages', [
            'dialogues' => $dialogues->map(fn(Dialogue $d) => $d->toArray())->all(),
            'currentUserId' => auth()->id(),
        ]);
    }
}
