<?php

namespace Chocofamily\PhalconHealthCheck\Services;

class HealthcheckConfigService
{
    private $config;

    public function __construct()
    {
        $this->config = include(__DIR__.'/../../healthcheck.php');
    }

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function get($key=null)
    {
        if ($key==null) {
            return $this->config;
        }

        return $this->config[$key];
    }
}
