<?php

namespace Modules\Scene\Shared\Repositories;

use Database\Models\Navbar;

final readonly class NavbarRepository
{
    public const string MAIN_NAVBAR = 'navbar_main';

    public function getByName(string $name)
    {
        return Navbar::where('name', $name)
            ->get()
            ->all();
    }
}
