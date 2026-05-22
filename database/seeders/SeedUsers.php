<?php

namespace Database\Seeders;

use Database\Models\Social\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedUsers extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => fake()->name(),
            'email' => 'admin@admin.admin',
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'editor@editor.editor',
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ]);
    }
}
