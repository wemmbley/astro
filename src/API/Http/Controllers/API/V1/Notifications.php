<?php

namespace API\Http\Controllers\API\V1;

use Database\Models\Notification;

class Notifications
{
    public function index()
    {
        $page = request()->input('page', 1);
        $userKey = auth()->user()->getKey();

        $notifications = Notification::where('user_id', $userKey)
            ->simplePaginate(5, ['*'], 'page', $page)
            ->toArray();

        return response()->json($notifications);
    }

    public function read(int $id): void
    {
        Notification::find($id)->markAsRead();
    }

    public function readAll(): void
    {
        $userKey = auth()->user()->getKey();

        Notification::where('user_id', $userKey)
            ->where('read', false)
            ->update(['read' => true]);
    }
}
