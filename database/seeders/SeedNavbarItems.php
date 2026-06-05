<?php

namespace Database\Seeders;

use Database\Models\Navbar;
use Illuminate\Database\Seeder;
use Modules\Actors\Auth\AuthRole;

final class SeedNavbarItems extends Seeder
{
    public function run(): void
    {
        $ifTableExists = Navbar::where('name', 'navbar_main')->exists();

        if ($ifTableExists) return;

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/',
            'label' => 'Главная',
        ])->assignRole(AuthRole::Guest->name);

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/matrix',
            'label' => 'Матрица',
        ])->assignRole(AuthRole::Guest->name);

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/natal',
            'label' => 'Натал',
        ])->assignRole(AuthRole::Guest->name);

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/glossary',
            'label' => 'Глосаррий',
        ])->assignRole(AuthRole::Guest->name);

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/feed',
            'label' => 'Лента',
        ])->assignRole(AuthRole::Guest->name);

        Navbar::create([
            'name' => 'navbar_main',
            'link' => '/subscriptions',
            'label' => 'Подписки',
        ])->assignRole(AuthRole::User->name);
    }
}
