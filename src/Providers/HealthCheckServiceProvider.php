<?php

namespace Chocofamily\PhalconHealthCheck\Providers;

use Chocofamily\PhalconHealthCheck\Controllers\HealthCheckController;
use Chocofamily\PhalconHealthCheck\Services\ComponentCheckService;
use Chocofamily\PhalconHealthCheck\Services\DefaultHealthCheckConfigService;
use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use \Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

class HealthCheckServiceProvider implements ServiceProviderInterface
{
    protected DiInterface $container;

    public function register(DiInterface $container): void
    {
        $this->container = $container;
        if ($this->getApp() instanceof Micro) {
            $config = $container->getShared('config');
            $this->mergePackageConfig($config);
            $this->importRoutes($config);

            $container->setShared('componentCheckService', new ComponentCheckService($container));
        }
    }

    private function mergePackageConfig(Config $config): void
    {
        $defaultHealthCheckConfigService = new DefaultHealthCheckConfigService();
        $healthCheckConfig               = new Config(
            [
                'healthcheck' => $defaultHealthCheckConfigService->get(),
            ]
        );
        $healthCheckConfig->merge($config->get('healthcheck', []));

        $config->merge($healthCheckConfig);
    }

    private function importRoutes(Config $config): void
    {
        $healthCheckConfig = $config->get('healthcheck');
        $routes            = [
            [
                'class'   => HealthCheckController::class,
                'methods' => [
                    $healthCheckConfig->get('route')         => [
                        'action' => 'simple',
                        'name'   => 'chocofamily-healthcheck',
                    ],
                    $healthCheckConfig->get('routeExtended') => [
                        'action' => 'extended',
                        'name'   => 'chocofamily-healthcheck-extended',
                    ],

                ],
            ],
        ];

        foreach ($routes as $route) {
            $collection = new MicroCollection();
            $collection->setHandler($route['class'], true);

            foreach ($route['methods'] as $endpoint => $action) {
                $collection->get($endpoint, $action['action'], $action['name']);
            }

            $this->getApp()->mount($collection);
        }
    }

    /**
     * @return Micro
     */
    public function getApp(): Micro
    {
        return $this->container->getShared('application');
    }
}
