<?php

namespace Database\Seeders;

use Database\Models\Interpretations\InterpretEntity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SeedInterpretationsMatrix extends Seeder
{
    private string $repoKey;

    public function __construct()
    {
        $this->repoKey = 'default:1.0.0';
    }

    public function run(): void
    {
        $this->seedArcanes();
        $this->seedChakras();
    }

    private function seedArcanes(): void
    {
        $this->seedFromDirectory(
            path: storage_path('interpretations/ru/Arcanes'),
            type: 'arcane',
            lang: 'ru',
        );
    }

    private function seedChakras(): void
    {
        $this->seedFromDirectory(
            path: storage_path('interpretations/ru/Chakras'),
            type: 'chakra',
            lang: 'ru',
        );
    }

    private function seedFromDirectory(string $path, string $type, string $lang): void
    {
        $files = File::files($path);

        $rows = collect($files)
            ->filter(fn($file) => $file->getExtension() === 'md')
            ->map(fn($file) => [
                'repository_key' => $this->repoKey,
                'name'           => $file->getFilenameWithoutExtension(),
                'type'           => $type,
                'content'        => File::get($file->getPathname()),
                'lang'           => $lang,
                'created_at'     => now(),
                'updated_at'     => now(),
            ])
            ->values()
            ->all();

        InterpretEntity::query()->insert($rows);
    }
}
