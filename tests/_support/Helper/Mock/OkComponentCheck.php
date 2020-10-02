<?php

namespace Helper\Mock;

use Phalcon\Di\DiInterface;

class OkComponentCheck implements \Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface
{

    private DiInterface $di;

    /**
     * Perform check
     */
    public function check(): void
    {

    }

    public function register(DiInterface $di): void {
        $this->di = $di;
    }
}
