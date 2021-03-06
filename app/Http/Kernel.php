<?php namespace Koolbeans\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Koolbeans\Http\Middleware\CoffeeShopIsOpenMiddleware;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Koolbeans\Http\Middleware\VerifyCsrfToken',
        'Barryvdh\Cors\Middleware\HandleCors',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin'      => 'Koolbeans\Http\Middleware\Admin',
        'auth'       => 'Koolbeans\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest'      => 'Koolbeans\Http\Middleware\RedirectIfAuthenticated',
        'owner'      => 'Koolbeans\Http\Middleware\IsCoffeeShopOwner',
        'open'       => CoffeeShopIsOpenMiddleware::class,
    ];

}
