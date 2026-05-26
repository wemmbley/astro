<?php

namespace Database\Seeders;

use Database\Models\Social\User;
use Database\Models\Social\UserDialogue;
use Database\Models\Social\UserDialogueParticipant;
use Database\Models\Social\UserDialogueMessage;
use Illuminate\Database\Seeder;

class SeedMessenger extends Seeder
{
    public function run(): void
    {
        $admin  = User::query()->where('email', 'admin@admin.admin')->first();
        $editor = User::query()->where('email', 'editor@editor.editor')->first();
        $test   = User::query()->where('email', 'test@test.test')->first();
        $nika   = User::query()->where('email', 'nika@nika.nika')->first();
        $nataly = User::query()->where('email', 'nataly@nataly.nataly')->first();
        $alina  = User::query()->where('email', 'alina@alina.alina')->first();

        // -------------------------------------------------------------------
        // Диалог 1: admin ↔ nika
        // -------------------------------------------------------------------
        $d1 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d1->id, 'user_id' => $admin->id, 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'user_id' => $nika->id,  'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            ['dialogue_id' => $d1->id, 'author_id' => $admin->id, 'user_message' => 'Привет, Милая!',        'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $nika->id,  'user_message' => 'Привет!!!',             'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $admin->id, 'user_message' => 'Я — тут!',              'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $admin->id, 'user_message' => 'Слышишь?',              'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $nika->id,  'user_message' => 'Йес',                   'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $admin->id, 'user_message' => 'Отлично!',              'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $admin->id, 'user_message' => 'Тогда — наша Священная Миссия начинается!!! О нас будут слагать легенды! Миф о Сизифе закончен! Настала новая эра!!!', 'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $nika->id,  'user_message' => '...',                   'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d1->id, 'author_id' => $nika->id,  'user_message' => 'ну допустим',           'read_at' => null,  'created_at' => now()],
        ]);

        // -------------------------------------------------------------------
        // Диалог 2: admin ↔ editor
        // -------------------------------------------------------------------
        $d2 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d2->id, 'user_id' => $admin->id,  'created_at' => now()],
            ['dialogue_id' => $d2->id, 'user_id' => $editor->id, 'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            ['dialogue_id' => $d2->id, 'author_id' => $admin->id,  'user_message' => 'Дороу',        'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d2->id, 'author_id' => $editor->id, 'user_message' => 'Я — редактор.','read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d2->id, 'author_id' => $admin->id,  'user_message' => 'Вижу)',         'read_at' => null,  'created_at' => now()],
        ]);

        // -------------------------------------------------------------------
        // Диалог 3: admin ↔ nataly
        // -------------------------------------------------------------------
        $d3 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d3->id, 'user_id' => $admin->id,  'created_at' => now()],
            ['dialogue_id' => $d3->id, 'user_id' => $nataly->id, 'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            ['dialogue_id' => $d3->id, 'author_id' => $nataly->id, 'user_message' => 'Ты сегодня онлайн?',      'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d3->id, 'author_id' => $admin->id,  'user_message' => 'Да, что-то случилось?',   'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d3->id, 'author_id' => $nataly->id, 'user_message' => 'Просто спросила)',         'read_at' => null,  'created_at' => now()],
        ]);

        // -------------------------------------------------------------------
        // Диалог 4: editor ↔ alina
        // -------------------------------------------------------------------
        $d4 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d4->id, 'user_id' => $editor->id, 'created_at' => now()],
            ['dialogue_id' => $d4->id, 'user_id' => $alina->id,  'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            ['dialogue_id' => $d4->id, 'author_id' => $editor->id, 'user_message' => 'Алин, ты сдала текст?',          'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d4->id, 'author_id' => $alina->id,  'user_message' => 'Ещё нет, завтра точно',           'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d4->id, 'author_id' => $editor->id, 'user_message' => 'Уже третий раз "завтра точно" 😅', 'read_at' => null,  'created_at' => now()],
        ]);

        // -------------------------------------------------------------------
        // Диалог 5: nika ↔ nataly
        // -------------------------------------------------------------------
        $d5 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d5->id, 'user_id' => $nika->id,   'created_at' => now()],
            ['dialogue_id' => $d5->id, 'user_id' => $nataly->id, 'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            // --- 20 мая (вторник) ---
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Наташ, где встречаемся?',    'read_at' => '2026-05-20 12:45:00', 'created_at' => '2026-05-20 12:40:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'Как обычно, у фонтана',      'read_at' => '2026-05-20 12:47:00', 'created_at' => '2026-05-20 12:42:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Окей, в 18:00?',             'read_at' => '2026-05-20 12:48:00', 'created_at' => '2026-05-20 12:43:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'Давай лучше в 18:30',        'read_at' => '2026-05-20 12:50:00', 'created_at' => '2026-05-20 12:45:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Оуууукей',                   'read_at' => '2026-05-20 12:52:00', 'created_at' => '2026-05-20 12:47:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'Чем занята?',                'read_at' => '2026-05-20 14:10:00', 'created_at' => '2026-05-20 14:05:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Смотрю натальную карту Рустама.))', 'read_at' => '2026-05-20 14:15:00', 'created_at' => '2026-05-20 14:08:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ахахахах :funny',            'read_at' => '2026-05-20 14:18:00', 'created_at' => '2026-05-20 14:12:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Ничего веселого :sad',       'read_at' => '2026-05-20 14:20:00', 'created_at' => '2026-05-20 14:14:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Он — Скорпион в душе',       'read_at' => '2026-05-20 14:22:00', 'created_at' => '2026-05-20 14:16:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Между тем это многое объясняет :zephir', 'read_at' => '2026-05-20 14:23:00', 'created_at' => '2026-05-20 14:17:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'замечательно :funny',        'read_at' => '2026-05-20 14:26:00', 'created_at' => '2026-05-20 14:19:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'а зачем тебе это?',          'read_at' => '2026-05-20 14:28:00', 'created_at' => '2026-05-20 14:21:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'чтобы знать его психологию', 'read_at' => '2026-05-20 14:30:00', 'created_at' => '2026-05-20 14:23:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'пон',                        'read_at' => '2026-05-20 14:32:00', 'created_at' => '2026-05-20 14:25:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'я одеваюсь',                 'read_at' => '2026-05-20 14:35:00', 'created_at' => '2026-05-20 14:28:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'окей',                       'read_at' => '2026-05-20 14:37:00', 'created_at' => '2026-05-20 14:30:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => ':good :good :good',          'read_at' => '2026-05-20 14:38:00', 'created_at' => '2026-05-20 14:31:00'],

            // --- 20 мая вечер (встреча, потом переписка) ---
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'вышла. холодно кстати',      'read_at' => '2026-05-20 18:32:00', 'created_at' => '2026-05-20 18:30:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'я говорила — возьми куртку', 'read_at' => '2026-05-20 18:34:00', 'created_at' => '2026-05-20 18:31:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'не говорила)',               'read_at' => '2026-05-20 18:36:00', 'created_at' => '2026-05-20 18:33:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'в прошлый раз говорила',     'read_at' => '2026-05-20 18:38:00', 'created_at' => '2026-05-20 18:34:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'это не считается',           'read_at' => '2026-05-20 18:40:00', 'created_at' => '2026-05-20 18:36:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => ':facepalm',                  'read_at' => '2026-05-20 18:42:00', 'created_at' => '2026-05-20 18:38:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ладно иду к фонтану',        'read_at' => '2026-05-20 18:44:00', 'created_at' => '2026-05-20 18:40:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'уже выхожу',                 'read_at' => '2026-05-20 18:46:00', 'created_at' => '2026-05-20 18:42:00'],

            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'стою у фонтана. тут голубь смотрит на меня очень подозрительно', 'read_at' => '2026-05-20 19:02:00', 'created_at' => '2026-05-20 19:00:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'это знак',                   'read_at' => '2026-05-20 19:05:00', 'created_at' => '2026-05-20 19:01:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'какой знак',                 'read_at' => '2026-05-20 19:08:00', 'created_at' => '2026-05-20 19:03:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'не знаю пока. смотри внимательно', 'read_at' => '2026-05-20 19:10:00', 'created_at' => '2026-05-20 19:05:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'он улетел',                  'read_at' => '2026-05-20 19:12:00', 'created_at' => '2026-05-20 19:07:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'знак исполнился',            'read_at' => '2026-05-20 19:15:00', 'created_at' => '2026-05-20 19:09:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ты ненормальная :funny',     'read_at' => '2026-05-20 19:18:00', 'created_at' => '2026-05-20 19:11:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'именно поэтому ты меня и любишь', 'read_at' => '2026-05-20 19:20:00', 'created_at' => '2026-05-20 19:13:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => '❤️',                         'read_at' => '2026-05-20 19:22:00', 'created_at' => '2026-05-20 19:15:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'уже почти там',              'read_at' => '2026-05-20 19:24:00', 'created_at' => '2026-05-20 19:16:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'вижу тебя',                  'read_at' => '2026-05-20 19:26:00', 'created_at' => '2026-05-20 19:18:00'],

            // --- 20 мая, после встречи (23:00 - 00:00) ---
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'дома уже',                   'read_at' => '2026-05-20 23:10:00', 'created_at' => '2026-05-20 23:00:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'я тоже',                     'read_at' => '2026-05-20 23:12:00', 'created_at' => '2026-05-20 23:02:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'хорошо сегодня посидели',    'read_at' => '2026-05-20 23:14:00', 'created_at' => '2026-05-20 23:04:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'да, давно так не смеялась',  'read_at' => '2026-05-20 23:17:00', 'created_at' => '2026-05-20 23:06:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'а когда ты про Рустама рассказала — я чуть кофе не пролила', 'read_at' => '2026-05-20 23:20:00', 'created_at' => '2026-05-20 23:08:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'так и надо было',            'read_at' => '2026-05-20 23:22:00', 'created_at' => '2026-05-20 23:10:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'он сегодня написал кстати',  'read_at' => '2026-05-20 23:25:00', 'created_at' => '2026-05-20 23:13:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'ЧТО',                        'read_at' => '2026-05-20 23:28:00', 'created_at' => '2026-05-20 23:15:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'и ты молчала весь вечер?!',  'read_at' => '2026-05-20 23:30:00', 'created_at' => '2026-05-20 23:17:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'не хотела поднимать тему при всех', 'read_at' => '2026-05-20 23:33:00', 'created_at' => '2026-05-20 23:19:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'там были только мы двое',    'read_at' => '2026-05-20 23:35:00', 'created_at' => '2026-05-20 23:21:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ну и что написал — спросил где я была', 'read_at' => '2026-05-20 23:38:00', 'created_at' => '2026-05-20 23:23:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Скорпион. ревнует.',         'read_at' => '2026-05-20 23:40:00', 'created_at' => '2026-05-20 23:25:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ты и твои карты :facepalm',  'read_at' => '2026-05-20 23:43:00', 'created_at' => '2026-05-20 23:27:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'карты не врут',              'read_at' => '2026-05-20 23:45:00', 'created_at' => '2026-05-20 23:29:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'я ответила что гуляла с подругой', 'read_at' => '2026-05-20 23:48:00', 'created_at' => '2026-05-20 23:31:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'и он?',                      'read_at' => '2026-05-20 23:50:00', 'created_at' => '2026-05-20 23:33:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'прочитал. не ответил.',      'read_at' => '2026-05-20 23:52:00', 'created_at' => '2026-05-20 23:35:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'классический Скорпион',      'read_at' => '2026-05-20 23:55:00', 'created_at' => '2026-05-20 23:37:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'переваривает',               'read_at' => '2026-05-20 23:57:00', 'created_at' => '2026-05-20 23:39:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'а мне что делать',           'read_at' => '2026-05-20 23:59:00', 'created_at' => '2026-05-20 23:41:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'ничего. пусть сам напишет.', 'read_at' => '2026-05-21 00:02:00', 'created_at' => '2026-05-20 23:43:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'легко сказать',              'read_at' => '2026-05-21 00:05:00', 'created_at' => '2026-05-20 23:45:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Наташ. ты знаешь что делать.', 'read_at' => '2026-05-21 00:08:00', 'created_at' => '2026-05-20 23:47:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'знаю',                       'read_at' => '2026-05-21 00:10:00', 'created_at' => '2026-05-20 23:49:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'просто страшно',             'read_at' => '2026-05-21 00:12:00', 'created_at' => '2026-05-20 23:51:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'страшно — значит важно',     'read_at' => '2026-05-21 00:15:00', 'created_at' => '2026-05-20 23:53:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => '...',                        'read_at' => '2026-05-21 00:17:00', 'created_at' => '2026-05-20 23:55:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'откуда ты такая умная',      'read_at' => '2026-05-21 00:20:00', 'created_at' => '2026-05-20 23:57:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'натальная карта :zephir',    'read_at' => '2026-05-21 00:23:00', 'created_at' => '2026-05-20 23:59:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ладно. спокойной ночи',      'read_at' => '2026-05-21 00:26:00', 'created_at' => '2026-05-21 00:01:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'спокойной. напиши если что', 'read_at' => '2026-05-21 00:29:00', 'created_at' => '2026-05-21 00:03:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'обязательно ❤️',             'read_at' => '2026-05-21 00:32:00', 'created_at' => '2026-05-21 00:05:00'],

            // --- 21 мая (среда) ---
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'Ник',                        'read_at' => '2026-05-21 09:10:00', 'created_at' => '2026-05-21 09:00:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'он написал',                 'read_at' => '2026-05-21 09:12:00', 'created_at' => '2026-05-21 09:02:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'я сплю',                     'read_at' => '2026-05-21 09:20:00', 'created_at' => '2026-05-21 09:05:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'ЧТО НАПИСАЛ',                'read_at' => '2026-05-21 09:22:00', 'created_at' => '2026-05-21 09:08:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'спрашивает хочу ли я сходить куда-нибудь', 'read_at' => '2026-05-21 09:25:00', 'created_at' => '2026-05-21 09:10:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'КАРТЫ НЕ ВРУТ',              'read_at' => '2026-05-21 09:28:00', 'created_at' => '2026-05-21 09:12:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'замолчи и помоги мне ответить', 'read_at' => '2026-05-21 09:30:00', 'created_at' => '2026-05-21 09:14:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'пиши: "да"',                 'read_at' => '2026-05-21 09:33:00', 'created_at' => '2026-05-21 09:16:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'это слишком просто',         'read_at' => '2026-05-21 09:35:00', 'created_at' => '2026-05-21 09:18:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'именно поэтому это правильно', 'read_at' => '2026-05-21 09:38:00', 'created_at' => '2026-05-21 09:20:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'написала',                   'read_at' => '2026-05-21 09:40:00', 'created_at' => '2026-05-21 09:22:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'умница',                     'read_at' => '2026-05-21 09:42:00', 'created_at' => '2026-05-21 09:24:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ответил сразу',              'read_at' => '2026-05-21 09:45:00', 'created_at' => '2026-05-21 09:26:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'в пятницу в 19:00',          'read_at' => '2026-05-21 09:47:00', 'created_at' => '2026-05-21 09:28:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'видишь. всё просто.',        'read_at' => '2026-05-21 09:50:00', 'created_at' => '2026-05-21 09:30:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'я боюсь',                    'read_at' => '2026-05-21 09:52:00', 'created_at' => '2026-05-21 09:32:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'я знаю. это хорошо.',        'read_at' => '2026-05-21 09:55:00', 'created_at' => '2026-05-21 09:34:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'что мне надеть',             'read_at' => '2026-05-21 09:58:00', 'created_at' => '2026-05-21 09:36:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'то синее платье',            'read_at' => '2026-05-21 10:01:00', 'created_at' => '2026-05-21 09:38:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'это же нарядное слишком',    'read_at' => '2026-05-21 10:04:00', 'created_at' => '2026-05-21 09:40:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'ты красивая. пусть смотрит.', 'read_at' => '2026-05-21 10:07:00', 'created_at' => '2026-05-21 09:42:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ой всё',                     'read_at' => '2026-05-21 10:10:00', 'created_at' => '2026-05-21 09:44:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => ':good',                      'read_at' => '2026-05-21 10:12:00', 'created_at' => '2026-05-21 09:46:00'],

            // --- 22 мая (четверг) ---
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'завтра',                     'read_at' => '2026-05-22 15:10:00', 'created_at' => '2026-05-22 15:00:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'знаю',                       'read_at' => '2026-05-22 15:13:00', 'created_at' => '2026-05-22 15:02:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'как ты?',                    'read_at' => '2026-05-22 15:15:00', 'created_at' => '2026-05-22 15:04:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'нервничаю немного',          'read_at' => '2026-05-22 15:18:00', 'created_at' => '2026-05-22 15:06:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'это нормально',              'read_at' => '2026-05-22 15:20:00', 'created_at' => '2026-05-22 15:08:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'а если будет awkward',       'read_at' => '2026-05-22 15:23:00', 'created_at' => '2026-05-22 15:10:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'не будет',                   'read_at' => '2026-05-22 15:25:00', 'created_at' => '2026-05-22 15:12:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ты не знаешь',               'read_at' => '2026-05-22 15:28:00', 'created_at' => '2026-05-22 15:14:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'знаю. карты.',               'read_at' => '2026-05-22 15:30:00', 'created_at' => '2026-05-22 15:16:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'это уже смешно',             'read_at' => '2026-05-22 15:33:00', 'created_at' => '2026-05-22 15:18:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'зато ты улыбнулась',         'read_at' => '2026-05-22 15:35:00', 'created_at' => '2026-05-22 15:20:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => '..да',                       'read_at' => '2026-05-22 15:38:00', 'created_at' => '2026-05-22 15:22:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'напишешь потом как было?',   'read_at' => '2026-05-22 15:40:00', 'created_at' => '2026-05-22 15:24:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'конечно',                    'read_at' => '2026-05-22 15:42:00', 'created_at' => '2026-05-22 15:26:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'удачи тебе. ты заслуживаешь хорошего', 'read_at' => '2026-05-22 15:45:00', 'created_at' => '2026-05-22 15:28:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'спасибо Ник',                'read_at' => '2026-05-22 15:48:00', 'created_at' => '2026-05-22 15:30:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'за всё',                     'read_at' => '2026-05-22 15:50:00', 'created_at' => '2026-05-22 15:32:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => '❤️',                         'read_at' => '2026-05-22 15:52:00', 'created_at' => '2026-05-22 15:34:00'],

            // --- 24 мая (воскресенье) - после свидания в пятницу 23 мая ---
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'Ника',                       'read_at' => '2026-05-24 12:10:00', 'created_at' => '2026-05-24 12:00:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'было хорошо',                'read_at' => '2026-05-24 12:12:00', 'created_at' => '2026-05-24 12:02:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'я ждала этого сообщения',    'read_at' => '2026-05-24 12:15:00', 'created_at' => '2026-05-24 12:04:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'рассказывай',                'read_at' => '2026-05-24 12:17:00', 'created_at' => '2026-05-24 12:06:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'мы гуляли часа три. разговаривали', 'read_at' => '2026-05-24 12:20:00', 'created_at' => '2026-05-24 12:08:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'он совсем не такой как я думала', 'read_at' => '2026-05-24 12:23:00', 'created_at' => '2026-05-24 12:10:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'в каком смысле?',            'read_at' => '2026-05-24 12:25:00', 'created_at' => '2026-05-24 12:12:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'мягче. тише. слушает.',      'read_at' => '2026-05-24 12:28:00', 'created_at' => '2026-05-24 12:14:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'Скорпионы умеют слушать когда хотят', 'read_at' => '2026-05-24 12:31:00', 'created_at' => '2026-05-24 12:16:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ну хватит уже со своими картами :funny', 'read_at' => '2026-05-24 12:34:00', 'created_at' => '2026-05-24 12:18:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'никогда',                    'read_at' => '2026-05-24 12:36:00', 'created_at' => '2026-05-24 12:20:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'он проводил меня',           'read_at' => '2026-05-24 12:39:00', 'created_at' => '2026-05-24 12:22:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'и спросил можно ли снова',   'read_at' => '2026-05-24 12:41:00', 'created_at' => '2026-05-24 12:24:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => '!!!',                        'read_at' => '2026-05-24 12:43:00', 'created_at' => '2026-05-24 12:26:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'и что ты ответила',          'read_at' => '2026-05-24 12:45:00', 'created_at' => '2026-05-24 12:28:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => '"да"',                       'read_at' => '2026-05-24 12:47:00', 'created_at' => '2026-05-24 12:30:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'умница',                     'read_at' => '2026-05-24 12:49:00', 'created_at' => '2026-05-24 12:32:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'именно поэтому это правильно :zephir', 'read_at' => '2026-05-24 12:52:00', 'created_at' => '2026-05-24 12:34:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'ты невыносима',              'read_at' => '2026-05-24 12:54:00', 'created_at' => '2026-05-24 12:36:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nataly->id, 'user_message' => 'и я тебя люблю',             'read_at' => '2026-05-24 12:56:00', 'created_at' => '2026-05-24 12:38:00'],
            ['dialogue_id' => $d5->id, 'author_id' => $nika->id,   'user_message' => 'взаимно ❤️',                 'read_at' => null,                  'created_at' => '2026-05-24 12:40:00'], // последнее сообщение не прочитано
        ]);

        // -------------------------------------------------------------------
        // Диалог 6: test ↔ alina
        // -------------------------------------------------------------------
        $d6 = UserDialogue::query()->create();
        UserDialogueParticipant::query()->insert([
            ['dialogue_id' => $d6->id, 'user_id' => $test->id,  'created_at' => now()],
            ['dialogue_id' => $d6->id, 'user_id' => $alina->id, 'created_at' => now()],
        ]);
        UserDialogueMessage::query()->insert([
            ['dialogue_id' => $d6->id, 'author_id' => $test->id,  'user_message' => 'Привет! Ты новенькая?',       'read_at' => now(), 'created_at' => now()],
            ['dialogue_id' => $d6->id, 'author_id' => $alina->id, 'user_message' => 'Ага, только зарегалась',      'read_at' => null,  'created_at' => now()],
        ]);
    }
}
