<?php

namespace Database\Seeders;

use database\Models\Interpretations\InterpretCuspidSign;
use database\Models\Interpretations\InterpretEntity;
use database\Models\Interpretations\InterpretPlanetAspect;
use database\Models\Interpretations\InterpretPlanetHouse;
use database\Models\Interpretations\InterpretPlanetSign;
use database\Models\Interpretations\InterpretRepository;
use database\Models\Navbar;
use database\Models\Post;
use database\Models\Social\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = $this->seedAdmin();
        $this->seedNavbars();
        $this->seedInterpretations($users);
        $this->seedPosts($users);
    }

    private function seedAdmin()
    {
        $userAdmin = User::create([
            'name' => fake()->name(),
            'email' => 'admin@admin.admin',
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ]);

        $userEditor = User::create([
            'name' => fake()->name(),
            'email' => 'editor@editor.editor',
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
        ]);

        return [
            'admin' => $userAdmin,
            'editor' => $userEditor,
        ];
    }

    private function seedPosts(array $users): void
    {
        Post::query()->where('email', 'admin@admin.admin')->create([
            'user_id' => $users['admin']->id,
            'slug' => 'saturn-v-karte',
            'title' => 'Сатурн в Карте. Алхимия элементов и типажей.',
            'content' => '# Сатурн в Карте

            Сатурн отвечает за дисциплину, зрелость, взрослость человека, его мудрость и время.

            Типичная реплика Сатурна: "это - развалится через год, фундамент здесь отсутсвует".

            Сатурн может быть всего 4х стихиях и обладать один из 3-х типажей.

            ![Saturn](https://i.pinimg.com/736x/fe/6d/8f/fe6d8f8a382945caebba59ea1a002771.jpg)

            ## Элементали Сатурна
            ### Сатурн Земли
            Земля - Обитель Сатурна. Твёрдая работа с материей "на века".  Такой Сатурн закладывает прочнейший фундамент, терпелив и надёжен.

            ### Сатурн Воды
            Вода - Изгнание для Сатурна. У него отсутствует структурность и чёткая форма. Вместо бетонной стены — зыбкое болото, страх, вязкость, непроявленные границы. Должен учиться у Сатурна Земли очерчивать границы и рамки, дедлайны.

            ### Сатурн Воздуха
            Нейтралитет. Кристаллизация и оформление идей и концепций в жёсткие структуры мыслительные. Так рождаются идеологии и концепции из идеии, имеющие плотную форму.

            ### Сатурн Огня
            Падение. Быстрое угасание любой инициативы, кроткосрочность вместо дальней перспективы и её удержания.

            ## Типажи Сатурна
            ### Сатурн Кардинальный
            Сатурн на старте. Он отвечает за инициацию через ограничения.

            Человек остро чувствует, что «начинать страшно», но надо. Он сам себе ставит дедлайны и жесткие рамки в начале любого дела.

            Постоянное чувство ответственности за старт. «Если не я нажму на газ, никто не поедет». Склонен к кризисам в момент инициативы.

            Не умеет расслабляться после старта — всегда должен быть следующий запуск.

            ## Сатурн Фиксированный
            Сатурн на удержание. Отвечает за сохранение формы под давлением времени.

            Это самый «бетонный» Сатурн. Он не строит быстро, но однажды построенное не разрушит никто. Терпение — железное.

            Типичная реплика: «Я это уже встроил в систему. Меняй что хочешь, это останется».

            Смертельная инертность. Если Сатурн-фиксация решил, что путь неправильный — он всё равно продолжит по нему идти 20 лет, потому что «так зафиксировано». Очень тяжело переучивается.

            ## Сатурн Мутабельный
            Сатурн на адаптацию. Отвечает за структурирование хаоса через правила и обучение.

            Этот Сатурн не строит стены. Он вяжет сеть или пишет кодекс законов. Ему нужно, чтобы всё менялось, но по правилам.

            Типичная реплика: «Система может быть гибкой, но в ней должен быть алгоритм на любой случай».

            Уход в абстрактную бюрократию. Вместо реального действия человек начинает создавать правила для правил.
            ',
        ]);

        Post::query()->where('email', 'admin@admin.admin')->create([
            'user_id' => $users['admin']->id,
            'slug' => 'solnce-v-karte',
            'title' => 'Солнце в Карте. Алхимия элементов и типажей.',
            'content' => '# Солнце в Карте
            Солнце отвечает за волю и творчество, а главное - стиль и эстетику исполнения собственной воли в поступках и делах.

            Типичная реплика Солнца: «Смотри, как я это сделал. Хочешь так же — ищи свой путь, а не копируй мой».

            ![Sun](https://i.pinimg.com/736x/fc/2c/a2/fc2ca2a34dd2e6d2ee01739573c59fa3.jpg)

            ## Элементали Солнца
            ### Солнце Огня
            Огонь — Обитель Солнца. Воля проявляется ярко, открыто, демонстративно. Человек творит себя через действие, риск, энтузиазм. Его стиль — быть видимым и вдохновлять.
            ### Солнце Земли
            Нейтралитет. Воля направлена на практический результат и телесное выражение. Стиль — надёжный, основательный, с чувством формы и фактуры. Красота через пользу.
            ### Солнце Воздуха
            Экзальтация. Воля реализуется через общение, контакты, этикет и стиль мышления. Эстетика исполнения — лёгкость, изящество, баланс, умение презентовать себя.
            ### Солнце Воды
            Падение. Воля течёт, но плохо оформляется вовне. Стиль — интуитивный, эмоциональный, зависящий от настроения. Человеку сложно показать себя прямо, он творит через эмпатию и искусство скрытых смыслов.

            ## Типажи Солнца
            ### Солнце Кардинальное
            Солнце на старте. Отвечает за волевой импульс в начале любого дела.

            Человек остро чувствует, что «надо заявить о себе прямо сейчас». Он первым начинает, задаёт тон, создаёт стиль с нуля. Его эстетика — вызов и новизна.

            Типичная реплика: «Я первый это сделал. Остальные догонят».

            Постоянное чувство: если не проявить волю сейчас — момент уйдёт навсегда. Склонен к выгоранию после яркого старта.

            Не умеет доводить до конца — ему важно только начать и обозначить стиль.
            ### Солнце Фиксированное
            Солнце на удержание. Отвечает за сохранение воли и стиля под любым давлением.

            Это самый «цельный» тип. Его не переубедить, не сломать, не заставить сменить манеру самовыражения. Он однажды нашёл свой стиль — и держится за него десятилетиями.

            Типичная реплика: «Я всегда был таким и не собираюсь меняться. Это и есть я».

            Смертельная ригидность. Если фиксированное Солнце ошиблось в выборе стиля или пути, оно будет продолжать идти по нему из принципа. Не умеет пересматривать свою волю.
            ### Солнце Мутабельное
            Солнце на адаптацию. Отвечает за гибкую волю и стиль, который подстраивается под обстоятельства.

            Этот тип не настаивает на своей уникальности. Он творит через подражание, переработку, смешение стилей. Легко меняет манеру поведения и самоподачи под ситуацию.

            Типичная реплика: «В каждой компании я немного разный. И все эти версии — настоящие».

            Уход в потерю себя. Человек так хорошо подстраивается под других, что перестаёт понимать — где его собственная воля, а где чужая. Стиль есть, но нет ядра.
            '
        ]);

        Post::query()->where('email', 'editor@editor.editor')->create([
            'user_id' => $users['editor']->id,
            'slug' => 'test-zapis',
            'title' => 'Всем привет!!! Моя тестовая запись!!!',
            'content' => '# Первая запись моего блога

            Это текст моей первой записи!!! Оставляйте комментарии!!! Очень интересно!!!',
        ]);
    }

    private function seedInterpretations(array $users): void
    {
        if (InterpretRepository::where('key', 'default:1.0.0')->exists()) {
            return;
        }

        $repo = InterpretRepository::create([
            'name'             => 'default',
            'key'              => 'default:1.0.0',
            'version'          => '1.0.0',
            'last_cached_date' => now(),
            'author_id'        => $users['admin']->getKey(),
            'stars'            => 0,
        ]);

        $repoKey = 'default:1.0.0';
        $lang    = 'ru';
        $base    = storage_path("interpretations/{$lang}");

        $planets = [
            'Chiron', 'Fortune', 'Jupiter', 'Lilith', 'Mars',
            'Mercury', 'Moon', 'Neptune', 'NorthNode', 'Pluto',
            'Saturn', 'Sun', 'Uranus', 'Venus',
        ];

        $aspects = ['Conjunction', 'Opposition', 'Sextile', 'Square', 'Trine'];

        $signs = [
            'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo',
            'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces',
        ];

        $houses = array_map(fn($n) => str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 12));

        // ── Верхнеуровневые аспекты → interpret_entity (type=aspect) ────────────
        foreach ($aspects as $aspect) {
            $content = $this->readFile("{$base}/Aspects/{$aspect}.md");
            if ($content === null) continue;

            InterpretEntity::create([
                'repository_key' => $repoKey,
                'name'           => $aspect,
                'type'           => 'aspect',
                'content'        => $content,
                'lang'           => $lang,
            ]);
        }

        // ── Дома ────────────────────────────────────────────────────────────────
        foreach ($houses as $house) {
            $houseDir = "{$base}/Houses/{$house}";

            if (!is_dir($houseDir)) continue;

            // Houses/{01}/{01}.md → interpret_entity (type=house)
            $content = $this->readFile("{$houseDir}/{$house}.md");
            if ($content !== null) {
                InterpretEntity::create([
                    'repository_key' => $repoKey,
                    'name'           => $house,
                    'type'           => 'house',
                    'content'        => $content,
                    'lang'           => $lang,
                ]);
            }

            // Houses/{01}/{Sign}.md → interpret_cuspid_sign
            foreach ($signs as $sign) {
                $content = $this->readFile("{$houseDir}/{$sign}.md");
                if ($content === null) continue;

                InterpretCuspidSign::create([
                    'repository_key' => $repoKey,
                    'house'          => $house,
                    'sign'           => $sign,
                    'content'        => $content,
                    'lang'           => $lang,
                ]);
            }
        }

        // ── Планеты ─────────────────────────────────────────────────────────────
        foreach ($planets as $planet) {
            $planetDir = "{$base}/Planets/{$planet}";

            if (!is_dir($planetDir)) continue;

            // Planets/{Planet}/{Planet}.md → interpret_entity (type=planet)
            $content = $this->readFile("{$planetDir}/{$planet}.md");
            if ($content !== null) {
                InterpretEntity::create([
                    'repository_key' => $repoKey,
                    'name'           => $planet,
                    'type'           => 'planet',
                    'content'        => $content,
                    'lang'           => $lang,
                ]);
            }

            // Planets/{Planet}/Signs/{Sign}.md → interpret_planet_sign
            foreach ($signs as $sign) {
                $content = $this->readFile("{$planetDir}/Signs/{$sign}.md");
                if ($content === null) continue;

                InterpretPlanetSign::create([
                    'repository_key' => $repoKey,
                    'planet'         => $planet,
                    'sign'           => $sign,
                    'content'        => $content,
                    'lang'           => $lang,
                ]);
            }

            // Planets/{Planet}/Houses/{01}.md → interpret_planet_house
            foreach ($houses as $house) {
                $content = $this->readFile("{$planetDir}/Houses/{$house}.md");
                if ($content === null) continue;

                InterpretPlanetHouse::create([
                    'repository_key' => $repoKey,
                    'planet'         => $planet,
                    'house'          => $house,
                    'content'        => $content,
                    'lang'           => $lang,
                ]);
            }

            // Planets/{Planet}/Aspects/{Aspect}/{ToPlanet}.md → interpret_planet_aspect
            foreach ($aspects as $aspect) {
                $aspectDir = "{$planetDir}/Aspects/{$aspect}";

                if (!is_dir($aspectDir)) continue;

                foreach ($planets as $toPlanet) {
                    $content = $this->readFile("{$aspectDir}/{$toPlanet}.md");
                    if ($content === null) continue;

                    InterpretPlanetAspect::create([
                        'repository_key' => $repoKey,
                        'planet'         => $planet,
                        'aspect'         => $aspect,
                        'to_planet'      => $toPlanet,
                        'content'        => $content,
                        'lang'           => $lang,
                    ]);
                }
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

    private function seedNavbars(): void
    {
        $ifTableExists = Navbar::where('name', 'navbar_main')
            ->exists();

        if ($ifTableExists) {
            return;
        }

        $navItems = [];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/',
            'label' => 'Главная',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/matrix',
            'label' => 'Матрица',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/natal',
            'label' => 'Натал',
        ];
        $navItems[] = [
            'name' => 'navbar_main',
            'link' => '/feed',
            'label' => 'Лента',
        ];

        Navbar::insert($navItems);
    }
}
