<?php

namespace Helper\Mock;

class CriticalComponentCheck implements \Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface
{

    /**
     * Perform check
     *
     * @throws \Exception
     */
    public function check()
    {
        throw new \Exception('Critical Exception');
    }
}
