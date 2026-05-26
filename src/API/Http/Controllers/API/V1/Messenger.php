<?php

namespace API\Http\Controllers\API\V1;

use Database\Models\Social\UserDialogue;
use Database\Models\Social\UserDialogueMessage;
use Database\Models\Social\UserDialogueParticipant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Messenger
{
    public function messages(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $isParticipant = UserDialogueParticipant::query()
            ->where('dialogue_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $limit    = min((int) $request->query('limit', 10), 50);
        $beforeId = $request->query('before_id');

        $query = UserDialogueMessage::query()
            ->where('dialogue_id', $id)
            ->orderByDesc('id');

        if ($beforeId) {
            $query->where('id', '<', (int) $beforeId);
        }

        $messages = $query
            ->limit($limit)
            ->get()
            ->sortBy('id')
            ->values();

        return response()->json(['data' => $messages]);
    }

    public function read(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $isParticipant = UserDialogueParticipant::query()
            ->where('dialogue_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        UserDialogueMessage::query()
            ->where('dialogue_id', $id)
            ->where('author_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function send(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $isParticipant = UserDialogueParticipant::query()
            ->where('dialogue_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate(['text' => 'required|string|max:5000']);

        $message = UserDialogueMessage::query()->create([
            'dialogue_id'  => $id,
            'author_id'    => $user->id,
            'user_message' => $request->input('text'),
            'read_at'      => null,
        ]);

        UserDialogue::query()->where('id', $id)->touch();

        return response()->json(['data' => $message]);
    }

    public function poll(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $isParticipant = UserDialogueParticipant::query()
            ->where('dialogue_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $afterId = (int) $request->query('after_id', 0);

        $messages = UserDialogueMessage::query()
            ->where('dialogue_id', $id)
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get();

        if ($messages->isNotEmpty()) {
            UserDialogueMessage::query()
                ->where('dialogue_id', $id)
                ->where('author_id', '!=', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json(['data' => $messages]);
    }
}
