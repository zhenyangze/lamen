<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
 */

require ROOT_PATH . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
 */

//$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);


// load config
$lamenConfig = get_lamen_config();
$ruleConfig = array_get($lamenConfig, 'rules');
$frameWork = 'laravel';
foreach($ruleConfig as $rule => $frameWorkName) {
    if (fnmatch($rule, $uri)) {
        $frameWork = $frameWorkName;
        break;
    }
}

// defind frame work name
if (!defined('FRAME_WORK_NAME')) {
    define('FRAME_WORK_NAME', $frameWork);
}

// check laravel or lumen
$bootConfig = array_get($lamenConfig, 'bootstrap');
$app = require_once array_get($bootConfig, FRAME_WORK_NAME);
if (FRAME_WORK_NAME == 'lumen') {
    $app->run();
} else {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
}
