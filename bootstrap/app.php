<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (Illuminate\Routing\Router $router) {
            $router->middleware('api')
                   ->prefix('api')
                   ->group(base_path('routes/api.php'));

            $router->middleware('web')
                   ->group(base_path('routes/web.php'));

            require base_path('routes/webhook.php');
        },
        
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
             'role' => CheckUserRole::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();