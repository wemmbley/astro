<?php

namespace Database\Seeders;

use Database\Models\Navbar;
use Illuminate\Database\Seeder;

class SeedNavbarItems extends Seeder
{
    public function run(): void
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
