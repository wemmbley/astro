<?php

namespace Database\Seeders;

use App\Models\Interpretations\InterpretRepository;
use App\Models\Navbar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedNavbars();
        $this->seedInterpretations();
    }

    private function seedInterpretations(): void
    {
        $isRepoExists = InterpretRepository::where('name', 'default')->exists();

        if($isRepoExists) {
            return;
        }

        InterpretRepository::create([
            'name' => 'default',
            'url' => '',
            'version' => '',
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
