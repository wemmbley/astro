<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use App\Models\Interpretations\InterpretCuspidSign;
use App\Models\Interpretations\InterpretRepository;
use Inertia\Inertia;
use Inertia\Response;

readonly class RepositoryController
{
    public function __construct(
        private GetNavbar $navbar,
    ) {}

    public function edit(string $repoKey): Response
    {
        $inertiaProps = [
            'navbar' => $this->navbar->execute(GetNavbar::MAIN_NAVBAR),
        ];

        $this->checkRepoExists($repoKey, $inertiaProps);

        if(isset($inertiaProps['error'])) {
            return Inertia::render('EditRepository', $inertiaProps);
        }

        $this->fillInertiaPropsWithRepositoryContent($repoKey, $inertiaProps);

        return Inertia::render('EditRepository', $inertiaProps);
    }

    private function checkRepoExists(string $repoKey, array &$inertiaProps): void
    {
        $repo = InterpretRepository::query()->where('key', $repoKey)->exists();

        if(!$repo) {
            $inertiaProps['error'] = 'Данный репозиторий не существует!';
        }
    }

    private function fillInertiaPropsWithRepositoryContent(string $repoKey, array &$inertiaProps)
    {
        $inertiaProps['repository']['cuspids'] = [];

        $cuspids = InterpretCuspidSign::query()
            ->where('repository_key', $repoKey)
            ->get()
            ->each(function (InterpretCuspidSign $cuspidSign) use($inertiaProps) {
                $inertiaProps['repository']['cuspids'][] = $cuspidSign->get()->toArray();
            });

        //dd($inertiaProps['repository']['cuspids']);
    }
}
