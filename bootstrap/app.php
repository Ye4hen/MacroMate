<?php

use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt' => JwtMiddleware::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(using: function (Exceptions $exceptions): void {
        $exceptions->render(using: function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                $model = class_basename($e->getPrevious()->getModel());
                return response()->json([
                    'message' => "{$model} not found."
                ], 404);
            }
        });

        // Force JSON detection if your client doesn’t send Accept: application/json
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->wantsJson() || $request->is('api/*');
        });
    })->create();
