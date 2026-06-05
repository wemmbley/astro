<?php

namespace Modules\Actors\Markdown;

class MDSeo
{
    /**
     * Главная точка входа.
     * Принимает AST из MarkdownAstParser::parse() и рендерит семантический HTML.
     */
    public static function render(array $ast): string
    {
        $html = '';

        foreach ($ast['sections'] ?? [] as $section) {
            $html .= static::renderSection($section);
        }

        return $html;
    }

    // -------------------------------------------------------------------------
    // Секция
    // -------------------------------------------------------------------------

    protected static function renderSection(array $section): string
    {
        $tag   = $section['type']['value'] ?? 'h2';   // h1..h6
        $title = htmlspecialchars($section['title'] ?? '', ENT_QUOTES);
        $id    = htmlspecialchars($section['name']  ?? '', ENT_QUOTES);

        $html  = '<section' . ($id ? " id=\"{$id}\"" : '') . '>';
        $html .= "<{$tag}>{$title}</{$tag}>";

        foreach ($section['content'] ?? [] as $block) {
            $html .= static::renderBlock($block);
        }

        $html .= '</section>';

        return $html;
    }

    // -------------------------------------------------------------------------
    // Блок — диспетчер по type
    // -------------------------------------------------------------------------

    protected static function renderBlock(array $block): string
    {
        // Вложенная секция (heading внутри content)
        if (($block['type']['name'] ?? null) === 'heading') {
            return static::renderSection($block);
        }

        return match ($block['type'] ?? '') {
            'paragraph'   => static::renderParagraph($block),
            'table'       => static::renderTable($block),
            'list'        => static::renderList($block),
            'blockquote'  => static::renderBlockquote($block),
            'code'        => static::renderCode($block),
            'code_inline' => static::renderCodeInline($block),
            'image'       => static::renderImage($block),
            'link'        => static::renderLink($block),
            'video'       => static::renderVideo($block),
            'divider'     => '<hr>',
            default       => '',
        };
    }

    // -------------------------------------------------------------------------
    // Примитивы
    // -------------------------------------------------------------------------

    protected static function renderParagraph(array $block): string
    {
        $value = static::normalizeText($block['value'] ?? '');
        if ($value === '') return '';
        return '<p>' . $value . '</p>';
    }

    protected static function renderTable(array $block): string
    {
        $html = '<table><thead><tr>';
        foreach ($block['headers'] ?? [] as $th) {
            $html .= '<th>' . htmlspecialchars($th, ENT_QUOTES) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($block['rows'] ?? [] as $row) {
            $html .= '<tr>';
            foreach ($row as $td) {
                $html .= '<td>' . htmlspecialchars($td, ENT_QUOTES) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }

    protected static function renderList(array $block): string
    {
        $tag  = ($block['style'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
        $html = "<{$tag}>";
        foreach ($block['items'] ?? [] as $item) {
            $html .= '<li>' . static::normalizeText($item) . '</li>';
        }
        $html .= "</{$tag}>";
        return $html;
    }

    protected static function renderBlockquote(array $block): string
    {
        $value = static::normalizeText($block['value'] ?? '');
        return '<blockquote>' . $value . '</blockquote>';
    }

    protected static function renderCode(array $block): string
    {
        $lang  = htmlspecialchars($block['language'] ?? '', ENT_QUOTES);
        $value = htmlspecialchars($block['value']    ?? '', ENT_QUOTES);
        $class = $lang ? " class=\"language-{$lang}\"" : '';
        return "<pre><code{$class}>{$value}</code></pre>";
    }

    protected static function renderCodeInline(array $block): string
    {
        return '<code>' . htmlspecialchars($block['value'] ?? '', ENT_QUOTES) . '</code>';
    }

    protected static function renderImage(array $block): string
    {
        $src = htmlspecialchars($block['src'] ?? '', ENT_QUOTES);
        $alt = htmlspecialchars($block['alt'] ?? '', ENT_QUOTES);
        return "<img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\">";
    }

    protected static function renderLink(array $block): string
    {
        $href = htmlspecialchars($block['href'] ?? '', ENT_QUOTES);
        $text = htmlspecialchars($block['text'] ?? '', ENT_QUOTES);
        return "<a href=\"{$href}\">{$text}</a>";
    }

    protected static function renderVideo(array $block): string
    {
        $src = $block['src'] ?? '';

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $src, $m)) {
            $id = $m[1];
            return '<iframe width="560" height="315"'
                . " src=\"https://www.youtube.com/embed/{$id}\""
                . ' frameborder="0" allowfullscreen loading="lazy"></iframe>';
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $src, $m)) {
            $id = $m[1];
            return '<iframe width="560" height="315"'
                . " src=\"https://player.vimeo.com/video/{$id}\""
                . ' frameborder="0" allowfullscreen loading="lazy"></iframe>';
        }

        // Прямой .mp4
        $escaped = htmlspecialchars($src, ENT_QUOTES);
        return "<video controls loading=\"lazy\"><source src=\"{$escaped}\"></video>";
    }

    // -------------------------------------------------------------------------
    // Утилиты
    // -------------------------------------------------------------------------

    /**
     * Нормализует текст параграфа:
     * - убирает переносы строк внутри (они из heredoc/многострочного markdown)
     * - value может уже содержать inline-HTML от inlineMarkdown()
     */
    protected static function normalizeText(string $text): string
    {
        // Схлопываем переносы + лишние пробелы в один пробел
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
