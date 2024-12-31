<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //

        $middleware->appendToGroup('web',[
            StartSession::class,
            SetLocale::class
        ]);

        $middleware->alias(
            [
                'auth.any' => \App\Http\Middleware\AuthCheckMiddleware::class
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
