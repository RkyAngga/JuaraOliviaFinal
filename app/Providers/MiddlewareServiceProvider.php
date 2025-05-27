<?php

namespace App\Providers;

use App\Http\Middleware\Role;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;

class MiddlewareServiceProvider extends RouteServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $router = $this->app->make(Router::class);
        
        // Register middleware aliases
        $router->aliasMiddleware('role', Role::class);
    }
} 