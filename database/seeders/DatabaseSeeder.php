<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            SeedUsers::class,
            SeedUserRoles::class,
            SeedNotifications::class,
            SeedMessenger::class,
            SeedPages::class,
            SeedPosts::class,
            SeedInterpretationsMatrix::class,
            SeedInterpretationsAstrology::class,
            SeedNavbarItems::class,
            SeedGeoCountries::class,
        ]);
    }
}
