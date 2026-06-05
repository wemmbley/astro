<?php

namespace Modules\Actors\Markdown;

class MDParser
{
    /**
     * Парсит Markdown-документ в AST-структуру для Vue-рендеринга.
     *
     * Формат результата:
     * [
     *   'attributes' => [...frontmatter],
     *   'sections'   => [
     *     [
     *       'name'    => 'faq',           // из [:faq]
     *       'type'    => ['name' => 'heading', 'value' => 'h1'],
     *       'heading' => 'Что такое Матрица Судьбы',
     *       'content' => [ ...блоки ],
     *     ],
     *     ...
     *   ]
     * ]
     */
    public function parse(string $markdown): array
    {
        [$frontmatter, $body] = $this->extractFrontmatter($markdown);
        $sections = $this->parseSections($body);

        return [
            'attributes' => $frontmatter,
            'sections'   => $sections,
        ];
    }

    // -------------------------------------------------------------------------
    // Frontmatter
    // -------------------------------------------------------------------------

    private function extractFrontmatter(string $markdown): array
    {
        $markdown = ltrim($markdown);

        if (!str_starts_with($markdown, '---')) {
            return [[], $markdown];
        }

        $end = strpos($markdown, '---', 3);
        if ($end === false) {
            return [[], $markdown];
        }

        $yaml   = substr($markdown, 3, $end - 3);
        $body   = ltrim(substr($markdown, $end + 3));
        $parsed = $this->parseYaml($yaml);

        return [$parsed, $body];
    }

    private function parseYaml(string $yaml): array
    {
        $result = [];
        foreach (explode("\n", $yaml) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $result[trim($key)] = trim($value, " \t\"'");
            }
        }
        return $result;
    }

    // -------------------------------------------------------------------------
    // Секции (вложенная структура по уровню #)
    // -------------------------------------------------------------------------

    private function parseSections(string $body): array
    {
        $lines  = explode("\n", $body);
        $buffer = [];

        // Сначала собираем плоский список «токенов»: heading + накопленный текст
        $tokens = [];

        $flushTokenBuffer = static function () use (&$buffer, &$tokens, &$lastHeading) {
            if ($buffer !== []) {
                $tokens[] = ['kind' => 'text', 'raw' => implode("\n", $buffer)];
                $buffer   = [];
            }
        };

        $lastHeading = null;

        foreach ($lines as $line) {
            $trimmed = ltrim($line);

            if (preg_match('/^(#{1,6})\s+(.+)$/', $trimmed, $m)) {
                $flushTokenBuffer();

                $level      = strlen($m[1]);
                $rawHeading = trim($m[2]);
                $name       = null;

                if (preg_match('/\[:([a-z0-9_-]+)\]\s*$/i', $rawHeading, $nm)) {
                    $name       = $nm[1];
                    $rawHeading = trim(preg_replace('/\[:([a-z0-9_-]+)\]\s*$/i', '', $rawHeading));
                }

                $tokens[] = [
                    'kind'    => 'heading',
                    'level'   => $level,
                    'name'    => $name,
                    'title'   => $rawHeading,
                ];
                continue;
            }

            $buffer[] = $trimmed;
        }

        $flushTokenBuffer();

        // Теперь строим дерево из плоского списка токенов.
        // Используем стек секций. Каждый элемент стека — указатель на секцию.
        // PHP не умеет хранить «ссылки в массиве» без workaround,
        // поэтому храним сам массив секций и пишем в него через вспомогательный метод.

        return $this->buildTree($tokens);
    }

    private function buildTree(array $tokens): array
    {
        // Рекурсивный descent: читаем токены и строим дерево.
        // idx передаётся по ссылке, чтобы дочерние вызовы двигали курсор.
        $idx  = 0;
        $tree = [];

        while ($idx < count($tokens)) {
            $token = $tokens[$idx];

            if ($token['kind'] !== 'heading') {
                // Текст без родительского заголовка — пропускаем (не должно быть)
                $idx++;
                continue;
            }

            $section = [
                'name'    => $token['name'],
                'type'    => ['name' => 'heading', 'value' => 'h' . $token['level']],
                'title'   => $token['title'],
                'level'   => $token['level'],
                'content' => [],
            ];

            $idx++;

            // Собираем content[] этой секции: текстовые блоки и дочерние секции
            while ($idx < count($tokens)) {
                $next = $tokens[$idx];

                if ($next['kind'] === 'heading' && $next['level'] <= $token['level']) {
                    // Следующий заголовок того же или выше уровня — выходим
                    break;
                }

                if ($next['kind'] === 'text') {
                    $blocks = $this->parseContentBlocks($next['raw']);
                    foreach ($blocks as $block) {
                        $section['content'][] = $block;
                    }
                    $idx++;
                    continue;
                }

                if ($next['kind'] === 'heading' && $next['level'] > $token['level']) {
                    // Дочерняя секция — рекурсивно собираем её и кладём в content[]
                    $children = $this->buildTree(array_slice($tokens, $idx));
                    // buildTree вернёт только первую секцию и остановится на одноуровневом/выше
                    // Нам нужен вариант с передачей $idx по ссылке — используем buildSubtree
                    $child = $this->buildSubtree($tokens, $idx, $token['level']);
                    $section['content'][] = $child;
                    continue;
                }

                $idx++;
            }

            $tree[] = $section;
        }

        return $tree;
    }

    private function buildSubtree(array $tokens, int &$idx, int $parentLevel): array
    {
        $token = $tokens[$idx];

        $section = [
            'name'    => $token['name'],
            'type'    => ['name' => 'heading', 'value' => 'h' . $token['level']],
            'title'   => $token['title'],
            'level'   => $token['level'],
            'content' => [],
        ];

        $idx++;

        while ($idx < count($tokens)) {
            $next = $tokens[$idx];

            // Стоп: вернулись на уровень родителя или выше
            if ($next['kind'] === 'heading' && $next['level'] <= $token['level']) {
                break;
            }

            if ($next['kind'] === 'text') {
                $blocks = $this->parseContentBlocks($next['raw']);
                foreach ($blocks as $block) {
                    $section['content'][] = $block;
                }
                $idx++;
                continue;
            }

            if ($next['kind'] === 'heading' && $next['level'] > $token['level']) {
                $child = $this->buildSubtree($tokens, $idx, $token['level']);
                $section['content'][] = $child;
                continue;
            }

            $idx++;
        }

        return $section;
    }

    // -------------------------------------------------------------------------
    // Блоки контента внутри секции
    // -------------------------------------------------------------------------

    /**
     * Принимает блок текста между заголовками.
     * Разбивает по двойному переносу строки → массив блоков.
     */
    private function parseContentBlocks(string $text): array
    {
        // Нормализуем переносы
        $text   = str_replace("\r\n", "\n", $text);
        $chunks = preg_split('/\n{2,}/', trim($text));
        $blocks = [];

        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }

            $block = $this->classifyBlock($chunk);
            if ($block !== null) {
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    /**
     * Определяет тип блока и возвращает нормализованную структуру.
     */
    private function classifyBlock(string $chunk): ?array
    {
        // --- Таблица Markdown
        if ($this->isTable($chunk)) {
            return $this->parseTable($chunk);
        }

        // --- Блок кода ```...```
        if (preg_match('/^```(\w*)\n([\s\S]+?)```$/m', $chunk, $m)) {
            return [
                'type'     => 'code',
                'language' => $m[1] ?: null,
                'value'    => trim($m[2]),
            ];
        }

        // --- Инлайн-код `...`
        if (preg_match('/^`([^`]+)`$/', $chunk, $m)) {
            return [
                'type'  => 'code_inline',
                'value' => $m[1],
            ];
        }

        // --- Изображение  ![alt](src)
        if (preg_match('/^!\[([^\]]*)\]\(([^)]+)\)$/', $chunk, $m)) {
            return [
                'type'  => 'image',
                'alt'   => $m[1],
                'src'   => $m[2],
            ];
        }

        // --- Ссылка [text](href)
        if (preg_match('/^\[([^\]]+)\]\(([^)]+)\)$/', $chunk, $m)) {
            return [
                'type'  => 'link',
                'text'  => $m[1],
                'href'  => $m[2],
            ];
        }

        // --- Видео-ссылка (youtube / vimeo / .mp4)
        if (preg_match('/^(https?:\/\/(www\.)?(youtube\.com|youtu\.be|vimeo\.com)\S+|.*\.mp4.*)$/i', $chunk)) {
            return [
                'type' => 'video',
                'src'  => $chunk,
            ];
        }

        // --- Нумерованный список
        $lines = explode("\n", $chunk);
        if ($this->isOrderedList($lines)) {
            return [
                'type'  => 'list',
                'style' => 'ordered',
                'items' => $this->extractListItems($lines, true),
            ];
        }

        // --- Маркированный список
        if ($this->isUnorderedList($lines)) {
            return [
                'type'  => 'list',
                'style' => 'unordered',
                'items' => $this->extractListItems($lines, false),
            ];
        }

        // --- Цитата > ...
        if (str_starts_with($lines[0], '>')) {
            $quoteLines = array_map(fn($l) => ltrim(ltrim($l, '>'), ' '), $lines);
            return [
                'type'  => 'blockquote',
                'value' => implode(' ', $quoteLines),
            ];
        }

        // --- Горизонтальный разделитель
        if (preg_match('/^[-*_]{3,}$/', trim($chunk))) {
            return ['type' => 'divider'];
        }

        // --- Параграф (по умолчанию)
        return [
            'type'  => 'paragraph',
            'value' => $this->inlineMarkdown($chunk),
        ];
    }

    // -------------------------------------------------------------------------
    // Таблицы
    // -------------------------------------------------------------------------

    private function isTable(string $chunk): bool
    {
        $lines = explode("\n", $chunk);
        return count($lines) >= 2
            && str_contains($lines[0], '|')
            && preg_match('/^\|?[\s\-:]+(\|[\s\-:]+)+\|?$/', $lines[1] ?? '');
    }

    private function parseTable(string $chunk): array
    {
        $lines   = explode("\n", $chunk);
        $headers = $this->splitTableRow($lines[0]);
        $rows    = [];

        foreach (array_slice($lines, 2) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $rows[] = $this->splitTableRow($line);
        }

        return [
            'type'    => 'table',
            'headers' => $headers,
            'rows'    => $rows,
        ];
    }

    private function splitTableRow(string $line): array
    {
        $line  = trim($line, '|');
        $cells = explode('|', $line);
        return array_map(fn($c) => $this->inlineMarkdown(trim($c)), $cells);
    }

    // -------------------------------------------------------------------------
    // Списки
    // -------------------------------------------------------------------------

    private function isUnorderedList(array $lines): bool
    {
        foreach ($lines as $line) {
            if (!preg_match('/^\s*[-*+]\s+/', $line)) {
                return false;
            }
        }
        return count($lines) > 0;
    }

    private function isOrderedList(array $lines): bool
    {
        foreach ($lines as $line) {
            if (!preg_match('/^\s*\d+[.)]\s+/', $line)) {
                return false;
            }
        }
        return count($lines) > 0;
    }

    private function extractListItems(array $lines, bool $ordered): array
    {
        return array_map(function ($line) use ($ordered) {
            $text = $ordered
                ? preg_replace('/^\s*\d+[.)]\s+/', '', $line)
                : preg_replace('/^\s*[-*+]\s+/', '', $line);
            return $this->inlineMarkdown(trim($text));
        }, $lines);
    }

    // -------------------------------------------------------------------------
    // Inline-разметка → HTML-строка (для Vue v-html)
    // -------------------------------------------------------------------------

    private function inlineMarkdown(string $text): string
    {
        // Жирный **text** или __text__
        $text = preg_replace('/\*\*(.+?)\*\*|__(.+?)__/', '<strong>$1$2</strong>', $text);
        // Курсив *text* или _text_
        $text = preg_replace('/\*(.+?)\*|_(.+?)_/', '<em>$1$2</em>', $text);
        // Инлайн-код `code`
        $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
        // Ссылки [text](href)
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);
        // Изображения ![alt](src)
        $text = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1">', $text);
        // Зачёркнутый ~~text~~
        $text = preg_replace('/~~(.+?)~~/', '<s>$1</s>', $text);

        return $text;
    }
}
