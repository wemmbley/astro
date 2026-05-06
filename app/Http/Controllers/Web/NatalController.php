<?php

namespace App\Http\Controllers\Web;

use App\Application\UseCases\Landing\GetNavbar;
use App\Modules\Natal\Application\UseCases\GenerateNatal;
use App\Modules\Natal\Domain\VO\Birthday;
use App\Modules\Natal\Infrastructure\NatalApiClient\PythonClient;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Http;

class NatalController
{
    public function index(GetNavbar $navbar): Response
    {
        return Inertia::render('Natal', [
            'navbar'  => $navbar->execute(GetNavbar::MAIN_NAVBAR),
            'planets' => [
                [
                    'icon'        => '☀️',
                    'name'        => 'Солнце',
                    'subtitle'    => 'Эго · Индивидуальность · Персона',
                    'description' => 'Солнце символизирует самоидентификацию человека — область, в которой мы должны быть независимы, реализовывать потенциал и сиять. Положение Солнца подскажет наиболее подходящую профессию.',
                    'chips'       => ['♑ Козерог', '6 дом'],
                    'image'       => 'https://i.pinimg.com/736x/71/b7/4f/71b74f6e42f38147df246018ac667011.jpg',
                    'sections'    => [
                        [
                            'icon'       => '♑',
                            'colorClass' => 'bg-amber-500/12',
                            'label'      => 'Знак',
                            'title'      => 'Солнце в Козероге',
                            'text'       => 'Знаком Козерога правит Сатурн — он дарит мир, терпение, настойчивость и честолюбие. Дружелюбные внешне, по сути серьёзны и ответственны.',
                            'link'       => 'https://ru.astro-seek.com/znak-zodiaka/kozerog',
                        ],
                        [
                            'icon'       => '🏠',
                            'colorClass' => 'bg-emerald-500/12',
                            'label'      => 'Дом',
                            'title'      => 'Солнце в 6-м доме',
                            'text'       => 'Стремление к успеху в работе, особенно в сфере здравоохранения и помощи другим. Создаёт целеустремлённых работников, часто достигающих успеха в административных должностях.',
                            'link'       => null,
                        ],
                    ],
                    'aspects' => [
                        [
                            'icon'      => '☿',
                            'type'      => 'conj',
                            'name'      => 'соединение Меркурий',
                            'orb'       => "1°49'",
                            'direction' => 'in',
                            'link'      => 'https://ru.astro-seek.com/...',
                        ],
                        [
                            'icon'      => '♂',
                            'type'      => 'sext',
                            'name'      => 'секстиль Марс',
                            'orb'       => "1°39'",
                            'direction' => 'out',
                            'link'      => 'https://ru.astro-seek.com/...',
                        ],
                        [
                            'icon'      => '⚷',
                            'type'      => 'chir',
                            'name'      => 'соединение Хирон',
                            'orb'       => "9°35'",
                            'direction' => 'out',
                            'link'      => null,
                        ],
                        [
                            'icon'      => '↕',
                            'type'      => 'cont',
                            'name'      => 'контра-параллель Асцендент',
                            'orb'       => "0°41'",
                            'direction' => null,
                            'link'      => 'https://ru.astro-seek.com/...',
                        ],
                        [
                            'icon'      => '↕',
                            'type'      => 'cont',
                            'name'      => 'контра-параллель Узел',
                            'orb'       => "0°58'",
                            'direction' => null,
                            'link'      => 'https://ru.astro-seek.com/...',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function single(GenerateNatal $natal, GetNavbar $navbar)
    {
        $birthday = new Birthday()->fromRoute(
            lat: (float) request('lat'),
            lon: (float) request('lon'),
            date: (string) request('date'),
            time: (string) request('time'),
        );

        $natal = $natal->execute($birthday);

        return Inertia::render('NatalSingle', [
            'navbar' => $navbar->execute(GetNavbar::MAIN_NAVBAR),
        ]);
    }
}
