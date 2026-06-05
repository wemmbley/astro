<?php

namespace Database\Seeders;

use Database\Models\Notification;
use Database\Models\Social\User;
use Illuminate\Database\Seeder;

final class SeedNotifications extends Seeder
{
    public function run()
    {
        $adminId = User::where('email', 'admin@admin.admin')->first()->getKey();

        Notification::query()->insert([
            [
                'user_id' => $adminId,
                'label' => 'Публикация записи',
                'text' => 'Ваша запись успешно опубликована!',
                'link' => '/post/test123',
                'read' => false,
            ],
            [
                'user_id' => $adminId,
                'label' => 'Лайк комментария',
                'text' => 'Ваш комментарий под записью Х понравился пользователю Y.',
                'link' => '/post/test123',
                'read' => true,
            ],
        ]);
    }
}
