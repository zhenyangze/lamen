<?php

namespace Lamen\Http\Server\Resetters;

use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Container\Container;
use Lamen\Http\Server\Resetters\ResetterContract;

class ResetConfig implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        $app->instance('config', clone $sandbox->getConfig());

        return $app;
    }
}
