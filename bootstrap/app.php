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
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // This is your existing middleware alias block. Leave it as is.
        $middleware->alias([
            'checked' => EnsureUserLoggedIn::class,
            'role' => EnsureUserRoleIsCorrect::class,
        ]);

        // REQUIRED CHANGE: Add this block to apply the security headers to all web routes.
        $middleware->web(append: [
            \App\Http\Middleware\AddSecurityHeaders::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();