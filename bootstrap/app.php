<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use UI\App\Middleware\HandleInertiaRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../src/UI/Routes/web.php',
        api: __DIR__.'/../src/API/Routes/api.php',
        commands: __DIR__.'/../workers/Timers/console.php',
        channels: __DIR__.'/../routes/channels.php',
    )
    ->withProviders([
        Providers\FortifyServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
