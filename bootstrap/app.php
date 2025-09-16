<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    // Enable facades and Eloquent
    ->withFacades()
    ->withEloquent()

    // Web routes
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // Middleware
    ->withMiddleware(function (Middleware $middleware): void {
        // Start session middleware
        $middleware->add(StartSession::class);

        // Optional: add CSRF middleware if you create VerifyCsrfToken
        // $middleware->add(App\Http\Middleware\VerifyCsrfToken::class);

        // Add any other middleware you need here
    })

    // Exception handling
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    // Force HTTPS in production
    ->create();

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}
