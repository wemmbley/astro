<?php

namespace Database\Seeders;

use Database\Models\Social\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Scene\Scenarios\Auth\UseCases\SetUserAvatar;
use Modules\Scene\Scenarios\Auth\UseCases\SetUserBanner;

final class SeedUsers extends Seeder
{
    public function __construct(
        private readonly SetUserAvatar $setUserAvatar,
        private readonly SetUserBanner $setUserBanner,
    ) {}

    public function run(): void
    {
        $this->createRegularUsers();
    }

    private function createRegularUsers(): void
    {
        $users = [
            ['email' => 'admin@admin.admin',    'sex' => 'm'],
            ['email' => 'editor@editor.editor', 'sex' => 'm'],
            ['email' => 'test@test.test',       'sex' => 'm'],
            ['email' => 'nika@nika.nika',       'sex' => 'f'],
            ['email' => 'nataly@nataly.nataly', 'sex' => 'f'],
            ['email' => 'alina@alina.alina',    'sex' => 'f'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => $userData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($userData['email']),
                'remember_token' => Str::random(10),
                'sex' => $userData['sex'],
            ]);

            $this->setUserAssets($user);
        }
    }

    private function setUserAssets(User $user): void
    {
        ($this->setUserAvatar)($user);
        ($this->setUserBanner)($user);
    }
}
