<?php
require_once ROOT_PATH . '/vendor/autoload.php';
try {
    (new Dotenv\Dotenv(ROOT_PATH))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(ROOT_PATH)
);

$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');
$app->instance('path.database', app()->basePath() . DIRECTORY_SEPARATOR . 'database');
$app->instance('path.public', app()->basePath() . DIRECTORY_SEPARATOR . 'public');

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    array_get(get_lamen_config('exceptions'), 'lumen')
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    array_get(get_lamen_config('consoles'), 'lumen')
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware(get_lamen_config('middlewares'));

$app->routeMiddleware(get_lamen_config('route_middlewares'));

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

foreach(get_lamen_config('providers') as $provider) {
    $app->register($provider);
}

use Symfony\Component\Finder\Finder;
foreach(get_lamen_config('configs') as $configPath) {
    foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file)
    {
        $filename = substr($file->getFileName(), 0, -4);
        if(empty($filename)){
            continue;
        }
        $app->make('config')->set($filename, array_merge(config($filename, []), require $file->getRealPath()));
    }
}

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| Load The Application Routes
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
 */

foreach(get_lamen_config('routes') as $routeConfig) {
    $group = array_get($routeConfig, 'group', []);
    $files = array_get($routeConfig, 'files', []);
    if (!empty($files)) {
        $app->router->group($group, function ($router) use ($files) {
            foreach($files as $file) {
                require $file;
            }
        });
    }
}

return $app;
