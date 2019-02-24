<?php

namespace Lamen\Http\Server\Resetters;

use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Container\Container;
use Lamen\Http\Server\Resetters\ResetterContract;

class ResetProviders implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        foreach ($sandbox->getProviders() as $provider) {
            $this->rebindProviderContainer($app, $provider);
            if (method_exists($provider, 'register')) {
                $provider->register();
            }
            if (method_exists($provider, 'boot')) {
                $app->call([$provider, 'boot']);
            }
        }

        return $app;
    }

    /**
     * Rebind service provider's container.
     */
    protected function rebindProviderContainer($app, $provider)
    {
        $closure = function () use ($app) {
            $this->app = $app;
        };

        $resetProvider = $closure->bindTo($provider, $provider);
        $resetProvider();
    }
}
