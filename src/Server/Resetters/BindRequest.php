<?php

namespace Lamen\Http\Server\Resetters;

use Illuminate\Http\Request;
use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Container\Container;
use Lamen\Http\Server\Resetters\ResetterContract;

class BindRequest implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        $request = $sandbox->getRequest();

        if ($request instanceof Request) {
            $app->instance('request', $request);
        }

        return $app;
    }
}
