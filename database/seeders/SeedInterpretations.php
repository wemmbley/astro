<?php

namespace Database\Seeders;

use Database\Models\Interpretations\InterpretCuspidSign;
use Database\Models\Interpretations\InterpretEntity;
use Database\Models\Interpretations\InterpretPlanetAspect;
use Database\Models\Interpretations\InterpretPlanetHouse;
use Database\Models\Interpretations\InterpretPlanetSign;
use Database\Models\Interpretations\InterpretRepository;
use Database\Models\Social\User;
use Illuminate\Database\Seeder;

class SeedInterpretations extends Seeder
{
    private array $aspects = [
        'Conjunction', 'Opposition', 'Sextile',
        'Square', 'Trine'
    ];

    private array $planets = [
        'Chiron', 'Fortune', 'Jupiter', 'Lilith', 'Mars',
        'Mercury', 'Moon', 'Neptune', 'NorthNode', 'Pluto',
        'Saturn', 'Sun', 'Uranus', 'Venus',
    ];

    private array $signs = [
        'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo',
        'Virgo', 'Libra', 'Scorpio', 'Sagittarius',
        'Capricorn', 'Aquarius', 'Pisces',
    ];

    private string $lang = 'ru';
    private string $basePath;
    private string $repoKey;
    private ?User $admin;

    public function __construct()
    {
        $this->basePath = storage_path("interpretations/{$this->lang}");
        $this->admin = User::where('email', 'admin@admin.admin')->first();
        $this->repoKey = 'default:1.0.0';
    }

    public function run()
    {
        $this->seedRepository();
        $this->seedAspects();
        $this->seedHouses();
        $this->seedPlanets();
    }

    private function seedRepository(): void
    {
        if (InterpretRepository::where('key', $this->repoKey)->exists()) {
            return;
        }

        InterpretRepository::create([
            'name'             => 'default',
            'key'              => $this->repoKey,
            'version'          => '1.0.0',
            'last_cached_date' => now(),
            'author_id'        => $this->admin?->getKey(),
            'stars'            => 0,
        ]);
    }

    private function seedAspects(): void
    {
        foreach ($this->aspects as $aspect) {
            $content = $this->readFile("{$this->basePath}/Aspects/{$aspect}.md");
            if ($content === null) continue;

            InterpretEntity::create([
                'repository_key' => $this->repoKey,
                'name'           => $aspect,
                'type'           => 'aspect',
                'content'        => $content,
                'lang'           => $this->lang,
            ]);

            $this->seedPlanetAspects($aspect);
        }
    }

    private function seedPlanetAspects(string $aspect): void
    {
        foreach ($this->planets as $planet) {
            $planetDir = "{$this->basePath}/Planets/{$planet}";

            if (!is_dir($planetDir)) continue;

            $aspectDir = "{$planetDir}/Aspects/{$aspect}";

            if (!is_dir($aspectDir)) continue;

            foreach ($this->planets as $toPlanet) {
                $content = $this->readFile("{$aspectDir}/{$toPlanet}.md");
                if ($content === null) continue;

                InterpretPlanetAspect::create([
                    'repository_key' => $this->repoKey,
                    'planet'         => $planet,
                    'aspect'         => $aspect,
                    'to_planet'      => $toPlanet,
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }
        }
    }

    private function seedHouses(): void
    {
        $houses = array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12));

        foreach ($houses as $house) {
            $houseDir = "{$this->basePath}/Houses/{$house}";

            if (!is_dir($houseDir)) continue;

            // Houses/{01}/{01}.md → interpret_entity (type=house)
            $content = $this->readFile("{$houseDir}/{$house}.md");
            if ($content !== null) {
                InterpretEntity::create([
                    'repository_key' => $this->repoKey,
                    'name'           => $house,
                    'type'           => 'house',
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }

            // Houses/{01}/{Sign}.md → interpret_cuspid_sign
            foreach ($this->signs as $sign) {
                $content = $this->readFile("{$houseDir}/{$sign}.md");
                if ($content === null) continue;

                InterpretCuspidSign::create([
                    'repository_key' => $this->repoKey,
                    'house'          => $house,
                    'sign'           => $sign,
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }
        }
    }

    private function seedPlanets(): void
    {
        $houses = array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12));

        foreach ($this->planets as $planet) {
            $planetDir = "{$this->basePath}/Planets/{$planet}";

            if (!is_dir($planetDir)) continue;

            // Planets/{Planet}/{Planet}.md → interpret_entity (type=planet)
            $content = $this->readFile("{$planetDir}/{$planet}.md");
            if ($content !== null) {
                InterpretEntity::create([
                    'repository_key' => $this->repoKey,
                    'name'           => $planet,
                    'type'           => 'planet',
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }

            // Planets/{Planet}/Signs/{Sign}.md → interpret_planet_sign
            foreach ($this->signs as $sign) {
                $content = $this->readFile("{$planetDir}/Signs/{$sign}.md");
                if ($content === null) continue;

                InterpretPlanetSign::create([
                    'repository_key' => $this->repoKey,
                    'planet'         => $planet,
                    'sign'           => $sign,
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }

            // Planets/{Planet}/Houses/{01}.md → interpret_planet_house
            foreach ($houses as $house) {
                $content = $this->readFile("{$planetDir}/Houses/{$house}.md");
                if ($content === null) continue;

                InterpretPlanetHouse::create([
                    'repository_key' => $this->repoKey,
                    'planet'         => $planet,
                    'house'          => $house,
                    'content'        => $content,
                    'lang'           => $this->lang,
                ]);
            }
        }
    }

    private function readFile(string $path): ?string
    {
        if (!file_exists($path) || !is_readable($path)) {
            return null;
        }

        $content = file_get_contents($path);

        return ($content !== false && trim($content) !== '') ? $content : null;
    }
}
