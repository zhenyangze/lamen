<?php

namespace Lamen\Http\Server\Resetters;

use Lamen\Http\Server\Sandbox;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Container\Container;
use Lamen\Http\Server\Resetters\ResetterContract;

class RebindKernelContainer implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \Lamen\Http\Server\Sandbox $sandbox
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        if ($sandbox->isLaravel()) {
            $kernel = $app->make(Kernel::class);

            $closure = function () use ($app) {
                $this->app = $app;
            };

            $resetKernel = $closure->bindTo($kernel, $kernel);
            $resetKernel();
        }

        return $app;
    }
}
