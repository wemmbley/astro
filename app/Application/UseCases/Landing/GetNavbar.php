<?php

namespace App\Application\UseCases\Landing;

use App\Models\Navbar;

class GetNavbar
{
    public const string MAIN_NAVBAR = 'navbar_main';

    public function execute(string $name)
    {
        return Navbar::where('name', $name)->get()->all();
    }
}
