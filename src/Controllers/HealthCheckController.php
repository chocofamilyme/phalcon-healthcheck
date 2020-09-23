<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Controllers;

use Chocofamily\PhalconHealthCheck\Services\ComponentCheckService;
use Phalcon\Mvc\Controller;

/**
 * @property ComponentCheckService $componentCheckService
 */
class HealthCheckController extends Controller
{
    /**
     * @return mixed
     */
    public function simple()
    {
        $healthCheckConfig = $this->getDI()->get('config')->get('healthCheck');

        $checks        = $this->componentCheckService->getResponse();
        $responseClass = $healthCheckConfig->get('response');

        return (new $responseClass)->simpleResponse($checks);
    }


    /**
     * @return mixed|null
     */
    public function extended()
    {
        $healthCheckConfig = $this->getDI()->get('config')->get('healthCheck');

        if (null === $healthCheckConfig->get('extended')) {
            return null;
        }

        $checks        = $this->componentCheckService->getResponse();
        $responseClass = $healthCheckConfig->get('response');

        return (new $responseClass)->extendedResponse($checks);
    }
}
