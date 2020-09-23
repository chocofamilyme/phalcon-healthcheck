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
    protected string $serviceName = 'healthCheck';
    protected Micro $app;

    public function register(DiInterface $container): void
    {
        $app = $container->getShared('application');
        if ($app instanceof Micro) {
            $config = $container->getShared('config');
            $this->mergePackageConfig($config);
            $this->importRoutes($config);

            $container->setShared('componentCheckService', new ComponentCheckService($container));
        }
    }

    private function mergePackageConfig(Config $config): void
    {
        if (!$config->offsetExists($this->serviceName)) {
            $defaultHealthCheckConfigService = new DefaultHealthCheckConfigService();
            $healthCheckConfig               = new Config($defaultHealthCheckConfigService->get());
            $config->offsetSet($this->serviceName, new Config());
            $config->get($this->serviceName)->merge($healthCheckConfig);
        }
    }

    private function importRoutes(Config $config): void
    {
        $healthCheckConfig = $config->get($this->serviceName);

        $routes = [
            [
                'class'   => HealthCheckController::class,
                'methods' => [
                    [
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
            ],
        ];

        foreach ($routes as $route) {
            $collection = new MicroCollection();
            $collection->setHandler($route['class'], true);

            foreach ($route['methods'] as $verb => $methods) {
                foreach ($methods as $endpoint => $action) {
                    $collection->get($endpoint, $action['action'], $action['name']);
                }
            }

            $this->getApp()->mount($collection);
        }
    }

    /**
     * @return Micro
     */
    public function getApp(): Micro
    {
        return $this->app;
    }
}
