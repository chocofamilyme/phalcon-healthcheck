<?php

namespace Chocofamily\PhalconHealthCheck\Services;

use Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface;
use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Throwable;

class ComponentCheckService
{
    private Config $healthCheckConfig;
    private DiInterface $di;

    /**
     * ComponentCheck constructor.
     *
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di                = $di;
        $this->healthCheckConfig = $di->get('config')->get('healthcheck');
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        $checks         = $this->healthCheckConfig->get('componentChecks');
        $checkResponses = [];
        foreach ($checks as $checkTitle => $check) {
            if (null === $check) {
                continue;
            }

            /** @var ComponentCheckInterface $componentCheck */
            $componentCheck = new $check();
            $componentCheck->register($this->di);

            $response                    = $this->getStatus($componentCheck);
            $checkResponses[$checkTitle] = [
                'status'  => $response['status'],
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
    private function getStatus(Checks\ComponentCheckInterface $check): array
    {
        try {
            $check->check();

            return [
                'status'  => true,
                'message' => null,
            ];
        } catch (Throwable $exception) {
            return [
                'status'  => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
