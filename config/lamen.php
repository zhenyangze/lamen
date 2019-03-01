<?php
/**
 * Short description for lamen.php
 *
 * @package lamen
 * @author zhenyangze <zhenyangze@gmail.com>
 * @version 0.1
 * @copyright (C) 2019 zhenyangze <zhenyangze@gmail.com>
 * @license MIT
 */

return [
    // 入口规则
    // php-fpm 根据url来判断不同的入口
    // swoole 需要用nginx分发
    'rules' => [
        '*/api/v1/*' => 'lumen',
        '*' => 'laravel',
    ],
    'bootstrap' => [
        'laravel' => ROOT_PATH . '/bootstrap/app.php', // 保留框架不变
        //'lumen' => __DIR__ . '/../bootstrap/lumen.php',
        'lumen' => ROOT_PATH . '/vendor/yangze/lamen/src/FrameWork/bootstrap/lumen.php',
    ],
    'artisan' => [
        'laravel' => ROOT_PATH . '/artisan',
        'lumen' => ROOT_PATH . '/vendor/yangze/lamen/src/FrameWork/app/artisan_lumen',
    ],
    'exceptions' => [
        'laravel' => App\Exceptions\Handler::class,
        'lumen' => Lamen\Http\Exceptions\LumenException::class,
    ],
    'consoles' => [
        'laravel' => App\Console\Kernel::class,
        'lumen' => Lamen\Http\FrameWork\App\Console\Kernel::class,
    ],

    // 以下配置针对lumen处理
    //网站配置文件目录
    'configs' => [
        ROOT_PATH . '/config',
    ],
    // 中间件
    'middlewares' => [
        //App\Http\Middleware\OldMiddleware::class
    ],
    'route_middlewares' => [
        //'auth' => App\Http\Middleware\Authenticate::class,
        //'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ],
    // 服务提供
    'providers' => [
        Illuminate\Support\Facades\Config::class,
        Lamen\Http\FrameWork\App\Providers\LumenServiceProvider::class,
        //App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Lamen\Http\LumenServiceProvider::class,
    ],
    // 网站api路由文件，主要针对lumen
    'routes' => [
        [
            'group' => [
                'namespace' => 'App\Http\Controllers\Api',
                'prefix' => 'api',
            ],
            'files' => [
                ROOT_PATH . '/routes/api.php',
            ],
        ]
    ],
];