<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

$app = (new \App\Core\Kernel(ROOT . '/config.php'))
    // Controlleurs
    ->addController(\App\Controllers\Home::class)
    ->addController(\App\Controllers\Movie::class)
    ->addController(\App\Controllers\Show::class)
    ->addController(\App\Controllers\Actor::class)

    // Middlewares
    ->pipe(\App\Core\Middlewares\TrailingSlash::class)
    ->pipe(\App\Core\Middlewares\Render::class)
;

if (php_sapi_name() !== 'cli') {
    Http\Response\send($app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals()));
}
