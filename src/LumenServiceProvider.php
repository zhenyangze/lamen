<?php

namespace Lamen\Http;

use Lamen\Http\Server\Manager;

/**
 * @codeCoverageIgnore
 */
class LumenServiceProvider extends HttpServiceProvider
{
    protected $framework = 'lumen';
    /**
     * Register manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('swoole.manager', function ($app) {
            return new Manager($app, 'lumen');
        });
    }

    /**
     * Boot routes.
     *
     * @return void
     */
    protected function bootRoutes()
    {
        $app = $this->app;

        if (property_exists($app, 'router')) {
            $app->router->group(['namespace' => 'Lamen\Http\Controllers'], function ($app) {
                require __DIR__ . '/../routes/lumen_routes.php';
            });
        } else {
            $app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
                require __DIR__ . '/../routes/lumen_routes.php';
            });
        }
    }
}
