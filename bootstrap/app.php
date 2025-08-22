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
    // Registers the application's middleware.
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => App\Http\Middleware\Admin::class, // 'admin' alias maps to the Admin middleware
            'client' => App\Http\Middleware\Client::class, // 'client' alias maps to the Client middleware
            'status' => App\Http\Middleware\ClientStatus::class, // 'status' alias maps to the ClientStatus middleware
            'permission' => App\Http\Middleware\CheckPermission::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
