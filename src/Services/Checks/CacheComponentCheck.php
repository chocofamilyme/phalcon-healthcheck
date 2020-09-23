<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di\DiInterface;
use Phalcon\Text;
use RuntimeException;

class CacheComponentCheck implements ComponentCheckInterface
{
    private DiInterface $di;

    public function register(DiInterface $di): void
    {
        $this->di = $di;
    }

    public function check(): void
    {
        $cache = $this->di->get('cache');

        $key   = Text::random();
        $value = Text::random();
        $cache->set($key, $value, 3);

        if ($cache->get($key) !== $value) {
            throw new RuntimeException('Cache does not works as expected');
        }
    }
}
