<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure()
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
    )->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'restrict5'    => \App\Http\Middleware\RestrictRoleFive::class,
        'role5.only'   => \App\Http\Middleware\RoleFiveOnly::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

