<?php

use App\Domain\Exceptions\InvalidStatusTransition;
use App\Domain\Exceptions\UnauthorizedAction;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        App\Providers\AppServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (InvalidStatusTransition $e) {
            return new JsonResponse(['message' => $e->getMessage()], 422);
        });
        $exceptions->renderable(function (UnauthorizedAction $e) {
            return new JsonResponse(['message' => $e->getMessage()], 403);
        });
    })->create();
