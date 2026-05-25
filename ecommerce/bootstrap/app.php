<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ActiveUserMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\DeliveryMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\VendorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            ActiveUserMiddleware::class,
        ]);

        $middleware->alias([
            'admin'    => AdminMiddleware::class,
            'vendor'   => VendorMiddleware::class,
            'customer' => CustomerMiddleware::class,
            'delivery' => DeliveryMiddleware::class,
            'role'     => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Resource not found.'], 404);
            }
        });

        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        });
    })->create();
