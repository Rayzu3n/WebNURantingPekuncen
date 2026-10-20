<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'active.member' => \App\Http\Middleware\EnsureActiveMember::class,
            'active.account' => \App\Http\Middleware\EnsureActiveAccount::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Identity numbers must not be stored in session old input after validation errors.
        $exceptions->dontFlash(['nik', 'nik_fingerprint']);

        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
