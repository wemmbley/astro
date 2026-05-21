<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class AuthWebController
{
    public function __construct() {}

    public function auth(): Response
    {
        return Inertia::render('Authorization', []);
    }

    public function reg(): Response
    {
        return Inertia::render('Registration', []);
    }
}
