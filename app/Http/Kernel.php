<?php

namespace ETSIEmplea\Http;

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
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    /*protected $middlewareGroups = [
        'web' => [
            \ETSIEmplea\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \ETSIEmplea\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];*/

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \ETSIEmplea\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \ETSIEmplea\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'web' => \ETSIEmplea\Http\Middleware\EncryptCookies::class,
        'web' => \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        'web' => \Illuminate\Session\Middleware\StartSession::class,
        'admin' => App\Http\Middleware\Admin::class,
        //'web' => \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //'web' => \ETSIEmplea\Http\Middleware\VerifyCsrfToken::class,
    ];
}
