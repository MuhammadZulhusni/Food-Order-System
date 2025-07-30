<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases for easier use in routes
        $middleware->alias([
            'admin' => App\Http\Middleware\Admin::class, // 'admin' alias maps to Admin middleware
            'client' => App\Http\Middleware\Client::class // 'client' alias maps to Client middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();