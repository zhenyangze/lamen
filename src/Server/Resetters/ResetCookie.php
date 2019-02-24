<?php

namespace Lamen\Http\Server\Resetters;

use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Container\Container;
use Lamen\Http\Server\Resetters\ResetterContract;

class ResetCookie implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        if (isset($app['cookie'])) {
            $cookies = $app->make('cookie');
            foreach ($cookies->getQueuedCookies() as $key => $value) {
                $cookies->unqueue($key);
            }
        }

        return $app;
    }
}
