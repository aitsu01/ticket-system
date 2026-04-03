<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
    )
    ->withProviders([
        App\Providers\EventServiceProvider::class,
    ])


    ->withMiddleware(function (Middleware $middleware) {

   $middleware->alias([
    'auth' => \App\Http\Middleware\Authenticate::class,
]);

})
    ->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    });

})
    ->create();

 
