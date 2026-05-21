<?php

namespace UI\App\Controllers;

use Inertia\Inertia;

final readonly class AuthWebController
{
    public function __construct() {}

    public function auth()
    {
        return Inertia::render('Auth/Authorization', []);
    }

    public function reg()
    {
        return Inertia::render('Auth/Registration', []);
    }
}
