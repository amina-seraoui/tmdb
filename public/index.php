<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

$app = (new \App\Core\Kernel(ROOT . '/config.php'));

$res = $app;

if (php_sapi_name() !== 'cli') {
    Http\Response\send($app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals()));
}
