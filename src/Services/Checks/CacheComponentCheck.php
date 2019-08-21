<?php

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di;
use RuntimeException;

class CacheComponentCheck implements ComponentCheckInterface
{
    public function check(): void
    {
        $di = Di::getDefault();
        $cache = $di->get('cache');

        $key = 'randomKey';
        $value = 'randomValue';
        $cache->save($key, $value, 3);

        if($cache->get($key) != $value) {
            throw new RuntimeException('Cache does not works as expected');
        }
    }
}
