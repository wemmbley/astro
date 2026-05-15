<?php

namespace Database\Models\Analytics;

use Illuminate\Database\Eloquent\Model;
use WendellAdriel\Lift\Attributes\Fillable;
use WendellAdriel\Lift\Lift;

class PageView extends Model
{
    use Lift;

    #[Fillable]
    public int $user_id;

    #[Fillable]
    public string $url;

    #[Fillable]
    public string $country;

    #[Fillable]
    public string $utm_source;

    #[Fillable]
    public string $utm_medium;

    #[Fillable]
    public string $utm_campaign;

    #[Fillable]
    public string $fingerprint;
}
