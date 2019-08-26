<?php

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di;
use RuntimeException;

class SessionsComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $di = Di::getDefault();
        $session = $di->get('session');

        $key = 'randomKey';
        $value = 'randomValue';
        $session->set($key, $value);

        if($session->get($key) != $value) {
            throw new RuntimeException('Sessions does not works as expected');
        }
    }
}
