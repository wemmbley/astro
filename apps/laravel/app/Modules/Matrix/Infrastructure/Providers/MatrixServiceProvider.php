<?php

namespace App\Modules\Matrix\Infrastructure\Providers;

use App\Modules\Matrix\Infrastructure\Console\Commands\TestMatrixCommand;
use Illuminate\Support\ServiceProvider;

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
