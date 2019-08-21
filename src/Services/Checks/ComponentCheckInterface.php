<?php

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

interface ComponentCheckInterface
{
    /**
     * Perform check
     */
    public function check(): void;
}
