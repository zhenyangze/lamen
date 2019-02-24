<?php

namespace Lamen\Http\Server\Resetters;

use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Container\Container;

interface ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox);
}
