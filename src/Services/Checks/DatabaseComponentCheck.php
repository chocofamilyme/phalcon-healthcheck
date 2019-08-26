<?php


namespace Chocofamily\PhalconHealthCheck\Services\Checks;


use Phalcon\Di;

class DatabaseComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $di = Di::getDefault();
        $db = $di->get('db');
        $db->connect();
    }
}
