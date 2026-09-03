<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\CheckTermDeactivation;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check-admin'       => CheckAdminRole::class,
            'check-maintenance' => CheckMaintenanceMode::class,
            'check-term'        => CheckTermDeactivation::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
