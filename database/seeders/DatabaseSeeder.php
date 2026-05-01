<?php

namespace Database\Seeders;

use App\Models\Interpretations\InterpretRepository;
use App\Models\Navbar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedAdmin();
        $this->seedNavbars();
        $this->seedInterpretations();
    }

    private function seedAdmin(): void
    {
        User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ]);
    }

    private function seedInterpretations(): void
    {
        $isRepoExists = InterpretRepository::where('name', 'default')->exists();

        if($isRepoExists) {
            return;
        }

        InterpretRepository::create([
            'name' => 'default',
            'version' => '1.0.0',
            'last_cached_date' => now(),
        ]);
    }

    private function seedNavbars(): void
    {
        $ifTableExists = Navbar::where('name', 'navbar_main')
            ->exists();

        if ($ifTableExists) {
            return;
        }

        $navItems = [];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/',
            'label' => 'Главная',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/matrix',
            'label' => 'Матрица',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/natal',
            'label' => 'Натал',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/feed',
            'label' => 'Лента',
        ];

        Navbar::insert($navItems);
    }
}
