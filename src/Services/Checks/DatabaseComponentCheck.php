<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di\DiInterface;

class DatabaseComponentCheck implements ComponentCheckInterface
{
    private DiInterface $di;

    public function register(DiInterface $di): void
    {
        $this->di = $di;
    }

    public function check(): void
    {
        $db = $this->di->get('db');
        $db->connect();
    }
}
