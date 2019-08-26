<?php

namespace Chocofamily\PhalconHealthCheck\Services;

use Phalcon\Di;

class ComponentCheckService
{
    const OK = 'OK';
    const CRITICAL = 'CRITICAL';

    /**
     * @var array
     */
    private $checks;

    /**
     * ComponentCheck constructor.
     */
    public function __construct()
    {
        $di = Di::getDefault();
        $healthcheckConfig = $di->get('config')->get('healthcheck');
        $this->checks = $healthcheckConfig->get('componentChecks');
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        $checkResponses = [];
        foreach($this->checks as $checkTitle => $check)
        {
            $response = $this->getStatus((new $check));
            $checkResponses[$checkTitle] = [
                'status' => $response['status'],
                'message' => $response['message'],
            ];
        }
        return $checkResponses;
    }

    /**
     * @param Checks\ComponentCheckInterface $check
     *
     * @return array
     */
    private function getStatus(Checks\ComponentCheckInterface $check)
    {
        try
        {
            $check->check();
            return [
                'status' => true,
                'message' => null
            ];
        }
        catch(\Exception $exception)
        {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

}
