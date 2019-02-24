<?php

/**
 * This is only for `function not exists` in config/swoole_http.php.
 */
if (! function_exists('swoole_cpu_num')) {
    function swoole_cpu_num()
    {
        return;
    }
}

/**
 * This is only for `function not exists` in config/swoole_http.php.
 */
if (! defined('SWOOLE_SOCK_TCP')) {
    define('SWOOLE_SOCK_TCP', 1);
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/../../../../..');
}

if (!function_exists('get_lamen_config')) {
    function get_lamen_config($key = null) 
    {
        $baseFile = __DIR__ . '/../../config/lamen.php';
        $userFile = ROOT_PATH . '/lamen.php';
        $baseConfig = include $baseFile;
        $userConfig = [];
        if (is_file($userFile)) {
            $userConfig = include $userFile;
        }

        $config = array_merge($baseConfig, $userConfig);
        return array_get($config, $key);
    }
}
