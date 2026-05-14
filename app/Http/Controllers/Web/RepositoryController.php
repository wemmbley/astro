<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use App\Models\Interpretations\InterpretCuspidSign;
use App\Models\Interpretations\InterpretEntity;
use App\Models\Interpretations\InterpretPlanetAspect;
use App\Models\Interpretations\InterpretPlanetHouse;
use App\Models\Interpretations\InterpretPlanetSign;
use App\Models\Interpretations\InterpretRepository;
use Inertia\Inertia;
use Inertia\Response;

final readonly class RepositoryController
{
    const ASPECTS = [
        'Conjunction', 'Opposition', 'Trine', 'Square', 'Sextile',
        'Quintile', 'Quincunx', 'Parallel', 'Biquintile', 'Semisquare',
        'Contraparallel', 'Semisextile', 'Sesquiquadrate',
    ];

    const SIGNS = [
        'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo',
        'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces',
    ];

    const PLANETS = [
        'Chiron', 'Fortune', 'Jupiter', 'Lilith', 'Mars',
        'Mercury', 'Moon', 'Neptune', 'NorthNode', 'Pluto',
        'Saturn', 'Sun', 'Uranus', 'Venus',
    ];

    public function __construct(private GetNavbar $navbar) {}

    public function edit(string $repoKey): Response
    {
        $props = ['navbar' => $this->navbar->execute(GetNavbar::MAIN_NAVBAR)];

        if (!InterpretRepository::query()->where('key', $repoKey)->exists()) {
            $props['error'] = 'Данный репозиторий не существует!';
            return Inertia::render('EditRepository', $props);
        }

        $props['repository'] = [
            'key'  => $repoKey,
            'tree' => $this->buildTree($repoKey),
        ];

        return Inertia::render('EditRepository', $props);
    }

    private function buildTree(string $repoKey): array
    {
        $houses = array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12));

        // Грузим всё одним разом
        $entities     = InterpretEntity::where('repository_key', $repoKey)->get();
        $cuspidSigns  = InterpretCuspidSign::where('repository_key', $repoKey)->get();
        $planetSigns  = InterpretPlanetSign::where('repository_key', $repoKey)->get();
        $planetHouses = InterpretPlanetHouse::where('repository_key', $repoKey)->get();
        $planetAspects = InterpretPlanetAspect::where('repository_key', $repoKey)->get();

        $file = fn(string $id, string $name, ?string $content) => [
            'id'      => $id,
            'type'    => 'file',
            'name'    => $name,
            'content' => $content,
            'exists'  => $content !== null,
        ];

        // ── Aspects ──────────────────────────────────────────────────────────
        $aspectsFolder = [
            'id' => 'folder-aspects',
            'type' => 'folder',
            'name' => 'Aspects',
            'children' => array_map(fn($a) => $file(
                "entity-aspect-{$a}", "{$a}.md",
                $entities->firstWhere(fn($e) => $e->type === 'aspect' && $e->name === $a)?->content
            ), self::ASPECTS),
        ];

        // ── Houses ───────────────────────────────────────────────────────────
        $houseFolders = array_map(function ($house) use ($entities, $cuspidSigns, $file) {
            $children = [];

            // entity куспида
            $children[] = $file(
                "entity-house-{$house}", "{$house}.md",
                $entities->firstWhere(fn($e) => $e->type === 'house' && $e->name === $house)?->content
            );

            // знаки куспида
            foreach (self::SIGNS as $sign) {
                $children[] = $file(
                    "cuspid-{$house}-{$sign}", "{$sign}.md",
                    $cuspidSigns->firstWhere(fn($c) => $c->house === $house && $c->sign === $sign)?->content
                );
            }

            return [
                'id' => "folder-house-{$house}",
                'type' => 'folder',
                'name' => $house,
                'children' => $children
            ];
        }, array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12)));

        $housesFolder = [
            'id' => 'folder-houses',
            'type' => 'folder',
            'name' => 'Houses',
            'children' => $houseFolders,
        ];

        // ── Planets ──────────────────────────────────────────────────────────
        $planetFolders = array_map(function ($planet) use ($entities, $planetSigns, $planetHouses, $planetAspects, $file) {
            $houses = array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12));

            // Signs/
            $signsFolder = [
                'id' => "folder-{$planet}-signs",
                'type' => 'folder',
                'name' => 'Signs',
                'children' => array_map(fn($sign) => $file(
                    "planet-sign-{$planet}-{$sign}", "{$sign}.md",
                    $planetSigns->firstWhere(fn($r) => $r->planet === $planet && $r->sign === $sign)?->content
                ), self::SIGNS),
            ];

            // Houses/
            $housesFolder = [
                'id' => "folder-{$planet}-houses",
                'type' => 'folder',
                'name' => 'Houses',
                'children' => array_map(fn($house) => $file(
                    "planet-house-{$planet}-{$house}", "{$house}.md",
                    $planetHouses->firstWhere(fn($r) => $r->planet === $planet && $r->house === $house)?->content
                ), $houses),
            ];

            // Aspects/
            $aspectSubFolders = array_map(function ($aspect) use ($planet, $planetAspects, $file) {
                return [
                    'id' => "folder-{$planet}-aspect-{$aspect}",
                    'type' => 'folder',
                    'name' => $aspect,
                    'children' => array_map(fn($toPlanet) => $file(
                        "planet-aspect-{$planet}-{$aspect}-{$toPlanet}", "{$toPlanet}.md",
                        $planetAspects->firstWhere(fn($r) =>
                            $r->planet === $planet && $r->aspect === $aspect && $r->to_planet === $toPlanet
                        )?->content
                    ), self::PLANETS),
                ];
            }, self::ASPECTS);

            $aspectsFolder = [
                'id' => "folder-{$planet}-aspects",
                'type' => 'folder',
                'name' => 'Aspects',
                'children' => $aspectSubFolders,
            ];

            return [
                'id' => "folder-planet-{$planet}",
                'type' => 'folder',
                'name' => $planet,
                'children' => [
                    $signsFolder,
                    $housesFolder,
                    $aspectsFolder,
                    $file("entity-planet-{$planet}", "{$planet}.md",
                        $entities->firstWhere(fn($e) => $e->type === 'planet' && $e->name === $planet)?->content
                    ),
                ],
            ];
        }, self::PLANETS);

        $planetsFolder = [
            'id' => 'folder-planets',
            'type' => 'folder',
            'name' => 'Planets',
            'children' => $planetFolders,
        ];

        return [$aspectsFolder, $housesFolder, $planetsFolder];
    }
}
