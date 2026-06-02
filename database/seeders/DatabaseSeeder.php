<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            SeedUsers::class,
            SeedNotifications::class,
            SeedMessenger::class,
            SeedPosts::class,
            SeedInterpretationsMatrix::class,
            SeedInterpretationsAstrology::class,
            SeedNavbarItems::class,
            SeedUserRoles::class,
            SeedGeoCountries::class,
        ]);
    }
}
