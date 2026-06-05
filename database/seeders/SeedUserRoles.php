<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Actors\Auth\AuthRole;
use Spatie\Permission\Models\Role;

final class SeedUserRoles extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (AuthRole::cases() as $role) {
            Role::create(['name' => $role->value]);
        }
    }
}
