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
            'password' => Hash::make('admin@admin.admin'),
            'remember_token' => Str::random(10),
            'sex' => 'm',
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'editor@editor.editor',
            'email_verified_at' => now(),
            'password' => Hash::make('editor@editor.editor'),
            'remember_token' => Str::random(10),
            'sex' => 'f',
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'test@test.test',
            'email_verified_at' => now(),
            'password' => Hash::make('test@test.test'),
            'remember_token' => Str::random(10),
            'sex' => 'm',
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'nika@nika.nika',
            'email_verified_at' => now(),
            'password' => Hash::make('nika@nika.nika'),
            'remember_token' => Str::random(10),
            'sex' => 'f',
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'nataly@nataly.nataly',
            'email_verified_at' => now(),
            'password' => Hash::make('nataly@nataly.nataly'),
            'remember_token' => Str::random(10),
            'sex' => 'f',
        ]);

        User::create([
            'name' => fake()->name(),
            'email' => 'alina@alina.alina',
            'email_verified_at' => now(),
            'password' => Hash::make('alina@alina.alina'),
            'remember_token' => Str::random(10),
            'sex' => 'f',
        ]);
    }
}
