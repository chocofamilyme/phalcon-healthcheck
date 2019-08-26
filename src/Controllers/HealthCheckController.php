<?php

namespace Chocofamily\PhalconHealthCheck\Controllers;

use Chocofamily\PhalconHealthCheck\Services\ComponentCheckService;
use Phalcon\Di;

class HealthCheckController
{
    /**
     * @var ComponentCheckService
     */
    private $componentCheck;
    private $healthcheckConfig;

    /**
     * HealthCheckController constructor.
     */
    public function __construct()
    {
        $this->componentCheck = new ComponentCheckService();
        $di = Di::getDefault();
        $this->healthcheckConfig = $di->get('config')->get('healthcheck');
    }

    public function simple()
    {
        $checks = $this->componentCheck->getResponse();
        $responseClass = $this->healthcheckConfig->get('response');
        return (new $responseClass)->simpleResponse($checks);
    }


    public function extendet()
    {
        if(!$this->healthcheckConfig->get('extendet')) {
            return null;
        }

        $checks = $this->componentCheck->getResponse();
        $responseClass = $this->healthcheckConfig->get('response');
        return (new $responseClass)->extendetResponse($checks);
    }
}
