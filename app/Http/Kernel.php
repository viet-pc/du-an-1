<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [


        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'admin' => [
            'isLogged' => \App\Http\Middleware\AuthCheck::class,
            'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
            'check_role' => \App\Http\Middleware\StaffMiddleware::class,
        ],

        'check_view_permissions' => [
            'isLogged' => \App\Http\Middleware\AuthCheck::class,
            'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
            'check_role' => \App\Http\Middleware\StaffMiddleware::class,
            'check_view' => \App\Http\Middleware\ViewPermission::class,
        ],

        'check_create_permissions' => [
            'isLogged' => \App\Http\Middleware\AuthCheck::class,
            'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
            'check_role' => \App\Http\Middleware\StaffMiddleware::class,
            'check_create' => \App\Http\Middleware\CreatePermission::class,
        ],

        'check_edit_permissions' => [
            'isLogged' => \App\Http\Middleware\AuthCheck::class,
            'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
            'check_role' => \App\Http\Middleware\StaffMiddleware::class,
            'check_edit' => \App\Http\Middleware\EditPermission::class,
        ],

        'check_delete_permissions' => [
            'isLogged' => \App\Http\Middleware\AuthCheck::class,
            'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
            'check_role' => \App\Http\Middleware\StaffMiddleware::class,
            'check_delete' => \App\Http\Middleware\DeletePermission::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // custom middleware
        'isLogged' => \App\Http\Middleware\AuthCheck::class,
        'AlreadyLogIn' => \App\Http\Middleware\Alreadylogin::class,
        'role' => \App\Http\Middleware\RoleCheck::class,
        'HandleOrder' => \App\Http\Middleware\HandleOrder::class,

        // default
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    //ưu tiên
    protected $middlewarePriority = [
    ];
}
