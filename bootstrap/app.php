<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\IfLogin;
use App\Http\Middleware\ValidationUser;
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
            'ValidationUser' => ValidationUser::class,
            'IfLogin' => IfLogin::class,
            'Role' => CheckRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
