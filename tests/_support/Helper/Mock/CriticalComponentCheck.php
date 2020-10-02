<?php

namespace Helper\Mock;

use Phalcon\Di\DiInterface;

class CriticalComponentCheck implements \Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface
{
    private DiInterface $di;

    /**
     * Perform check
     *
     * @throws \Exception
     */
    public function check(): void
    {
        throw new \Exception('Critical Exception');
    }

    public function register(DiInterface $di): void {
        $this->di = $di;
    }
}
