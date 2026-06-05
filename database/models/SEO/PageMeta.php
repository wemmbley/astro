<?php

namespace Database\Models\SEO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageMeta extends Model
{
    public $fillable = [
        'page_id',
        'meta_key',
        'meta_value',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
