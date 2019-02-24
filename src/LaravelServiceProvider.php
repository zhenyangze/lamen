<?php

namespace Lamen\Http;

use Lamen\Http\Server\Manager;

/**
 * @codeCoverageIgnore
 */
class LaravelServiceProvider extends HttpServiceProvider
{
    protected $framework = 'laravel';
    /**
     * Register manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('swoole.manager', function ($app) {
            return new Manager($app, 'laravel');
        });
    }

    /**
     * Boot routes.
     *
     * @return void
     */
    protected function bootRoutes()
    {
        require __DIR__.'/../routes/laravel_routes.php';
    }
}
