<?php

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di;
use Phalcon\Text;
use RuntimeException;

class CacheComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $di = Di::getDefault();
        $cache = $di->get('cache');

        $key = Text::random();
        $value = Text::random();
        $cache->save($key, $value, 3);

        if($cache->get($key) != $value) {
            throw new RuntimeException('Cache does not works as expected');
        }
    }
}
