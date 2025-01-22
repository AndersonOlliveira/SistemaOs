<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\TrimStrings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(TrimStrings::class);
        //ALTEERADO O REDIRECT PARA A PAGINA DE LOGIN QUANDO A PESSOA NÁO ESTIVER AUTENTICAD
        $middleware->redirectGuestsTo('/');

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
