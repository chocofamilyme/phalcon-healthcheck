<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Di\DiInterface;
use Phalcon\Text;
use RuntimeException;

class SessionsComponentCheck implements ComponentCheckInterface
{
    private DiInterface $di;

    public function register(DiInterface $di): void
    {
        $this->di = $di;
    }

    public function check(): void
    {
        $session = $this->di->get('session');

        $key   = Text::random();
        $value = Text::random();
        $session->set($key, $value);

        if ($session->get($key) !== $value) {
            throw new RuntimeException('Sessions does not works as expected');
        }
    }
}
