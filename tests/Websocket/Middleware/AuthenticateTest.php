<?php

namespace Lamen\Http\Tests\Websocket\Middleware;

use Mockery as m;
use Illuminate\Http\Request;
use Lamen\Http\Tests\TestCase;
use Illuminate\Contracts\Auth\Factory as Auth;
use Lamen\Http\Websocket\Middleware\Authenticate;

class AuthenticateTest extends TestCase
{
    public function testAuthenticate()
    {
        $auth = m::mock(Auth::class);
        $auth->shouldReceive('authenticate')
            ->once()
            ->andReturn('user');

        $request = m::mock(Request::class);
        $request->shouldReceive('setUserResolver')
            ->once();

        $middleware = new Authenticate($auth);
        $middleware->handle($request, function ($next) {
            return $next;
        });
    }
}