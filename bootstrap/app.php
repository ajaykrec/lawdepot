<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function () {

            Route::middleware('api')
                ->prefix('v1/api')
                ->group(base_path('routes/v1/api.php'));  
            
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/web_admin.php'));

            Route::middleware('web')
                 ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->use([
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,           
        ]);

        $middleware->append('\App\Http\Middleware\CorsMiddleware::class');

        $middleware->validateCsrfTokens(except: [
            'checkout-success',
            'checkout-callback',
        ]);

        $middleware->alias([            
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.customer' => \App\Http\Middleware\Authenticate_customer::class,
            'lang' => \App\Http\Middleware\SetLang::class,
            'front_view' => \App\Http\Middleware\HandleInertiaRequests::class,
            //'admin_view' => \App\Http\Middleware\HandleInertiaAdminRequests::class,
            //'sanctum' => \App\Http\Middleware\Sanctum::class,             
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
