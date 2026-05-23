<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class AuthWebController
{
    public function __construct() {}

    public function auth(): Response
    {
        seo()->title('Astre | Авторизация');

        return Inertia::render('Authorization', []);
    }

    public function reg(): Response
    {
        seo()->title('Astre | Регистрация');

        return Inertia::render('Registration', []);
    }
}
