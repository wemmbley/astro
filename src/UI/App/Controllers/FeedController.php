<?php

namespace UI\App\Controllers;

use Inertia\Inertia;
use Inertia\Response;

final readonly class FeedController
{
    public function index(): Response
    {
        return Inertia::render('Feed', []);
    }
}
