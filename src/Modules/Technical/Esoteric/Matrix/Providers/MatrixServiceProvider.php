<?php

namespace Modules\Technical\Esoteric\Matrix\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Technical\Esoteric\Matrix\Console\Commands\TestMatrixCommand;

class MatrixServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestMatrixCommand::class,
            ]);
        }
    }
    public function register(): void
    {

    }
}
