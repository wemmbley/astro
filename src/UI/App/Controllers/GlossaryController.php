<?php

namespace UI\App\Controllers;

use Database\Models\Interpretations\InterpretEntity;
use Inertia\Inertia;
use Inertia\Response;

final readonly class GlossaryController
{
    public function index(): Response
    {
        return Inertia::render('Glossary', [

        ]);
    }

    public function entity()
    {
        InterpretEntity::query()
            ->where('repository_key', 'default:1.0.0')

            ->first();
    }
}
