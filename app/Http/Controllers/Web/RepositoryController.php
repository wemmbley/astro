<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use Inertia\Inertia;
use Inertia\Response;

readonly class RepositoryController
{
    public function __construct(
        private GetNavbar $navbar,
    ) {}

    public function edit(string $repoKey): Response
    {
        return Inertia::render('EditRepository', [
            'navbar' => $this->navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
