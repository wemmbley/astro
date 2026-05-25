<?php

namespace UI\App\Controllers;

use Inertia\Inertia;

class MessagesController
{
    public function index()
    {
        seo()->title('(1) Личные сообщения');

        return Inertia::render('Messages', []);
    }
}
