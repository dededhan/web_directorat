<?php

use App\Http\Middleware\EnsureUserLoggedIn;
use App\Http\Middleware\EnsureUserRole;
use App\Http\Middleware\EnsureUserRoleIsCorrect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checked' => EnsureUserLoggedIn::class,
            'role' => EnsureUserRoleIsCorrect::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
