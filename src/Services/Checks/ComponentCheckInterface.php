<?php

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di\DiInterface;

interface ComponentCheckInterface
{
    /**
     * Perform check
     */
    public function check();

    public function register(DiInterface $di): void;
}
