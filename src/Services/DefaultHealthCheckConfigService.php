<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Services;

class DefaultHealthCheckConfigService
{
    private array $config;

    public function __construct()
    {
        $this->config = include(__DIR__.'/../../healthcheck.php');
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function get(?string $key = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return $this->config[$key];
    }
}
