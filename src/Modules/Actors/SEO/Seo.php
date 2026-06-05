<?php

namespace Modules\Actors\SEO;

use Database\Models\SEO\Page;
use Modules\Actors\Markdown\MDParser;
use Modules\Actors\Markdown\MDSeo;

class Seo
{
    public static function get(SeoSitePages $seoPage): string
    {
        $seo = Page::query()
            ->where('name', $seoPage->value)
            ->first();
        $parser = new MDParser();

        self::setSeoGlobally($seo);

        $htmlSeo = MDSeo::render(
            $parser->parse($seo->content)
        );

        return $htmlSeo;
    }

    private static function setSeoGlobally(Page $seoPage): void
    {
        seo()
            ->title($seoPage->title)
            ->description($seoPage->description);
    }
}
