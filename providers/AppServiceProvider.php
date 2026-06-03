<?php

namespace Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        View::addNamespace('UI', base_path('src/UI'));
    }

    public function boot(): void
    {

    }
}
