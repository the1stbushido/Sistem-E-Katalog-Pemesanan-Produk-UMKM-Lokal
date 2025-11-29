<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- INI YANG ANDA TAMBAHKAN DARI LANGKAH 8 ---
        // Daftarkan alias 'role' agar bisa dipakai di routes/web.php
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'api_role' => \App\Http\Middleware\ApiRoleMiddleware::class,
        ]);
        // ----------------------------------------------

        // Middleware bawaan Breeze/Laravel (biarkan saja)
        $middleware->web(append: [
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();