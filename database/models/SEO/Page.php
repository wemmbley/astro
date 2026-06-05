<?php

namespace Database\Models\SEO;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $fillable = [
        'title',
        'description',
        'content',
        'slug',
    ];

    public function getContent()
    {
        // mutate by markdown before show.
    }
}
