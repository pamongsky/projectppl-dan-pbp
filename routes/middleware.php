<?php

use App\Http\Middleware\RoleMiddleware;

return [
    // Middleware role
    'role' => RoleMiddleware::class,

    // Middleware bawaan Laravel (opsional, jika diperlukan)
    // 'auth' => \App\Http\Middleware\Authenticate::class,
    // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];
