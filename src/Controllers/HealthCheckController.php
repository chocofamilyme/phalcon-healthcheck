<?php

namespace Chocofamily\PhalconHealthCheck\Controllers;

use Chocofamily\PhalconHealthCheck\Responses\ChocofamilyResponse;
use Chocofamily\PhalconHealthCheck\Services\ComponentCheckService;

class HealthCheckController
{
    /**
     * @var ComponentCheckService
     */
    private $componentCheck;

    /**
     * HealthCheckController constructor.
     */
    public function __construct()
    {
        $this->componentCheck = new ComponentCheckService();
    }

    public function simple()
    {
        $checks = $this->componentCheck->getResponse();
        $responseClass = config('healthcheck.response');
        return (new $responseClass)->simpleResponse($checks);
    }


    public function extendet()
    {
        if(!config('healthcheck.extendet')) {
            return null;
        }

        $checks = $this->componentCheck->getResponse();
        $responseClass = config('healthcheck.response');
        return (new $responseClass)->extendetResponse($checks);
    }
}
