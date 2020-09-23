<?php

namespace Chocofamily\PhalconHealthCheck\Services;

class DefaultHealthCheckConfigService
{
    private $config;

    public function __construct()
    {
        $this->config = include(__DIR__.'/../../healthCheck.php');
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
