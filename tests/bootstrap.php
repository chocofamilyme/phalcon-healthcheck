<?php

require_once __DIR__.'/../vendor/autoload.php';

use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        return new \Phalcon\Config([

        ]);
    }
);

return new Application($di);
