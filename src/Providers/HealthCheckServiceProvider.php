<?php

namespace Chocofamily\PhalconHealthCheck\Providers;

use Chocofamily\PhalconHealthCheck\Services\HealthcheckDefaultConfigService;
use Phalcon\Config;
use Phalcon\Di;
use \Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Mvc\User\Component;

class HealthCheckServiceProvider extends Component
{
    /**
     * The Service name.
     *
     * @var string
     */
    protected $serviceName = 'healthcheck';

    protected $app;

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        if ($this->getApp() instanceof Micro) {
            $di     = Di::getDefault();
            $config = $di->get('config');
            $this->mergePackageConfig($config);
            $this->importRoutes($config);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return $this->serviceName;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function configure()
    {
    }

    private function mergePackageConfig(Config &$config)
    {
        if (!$config->offsetExists($this->serviceName)) {
            $healthcheckDefaultConfigService = new HealthcheckDefaultConfigService();
            $healthcheckConfig = new Config($healthcheckDefaultConfigService->get());
            $config->offsetSet($this->serviceName, new Config());
            $config->get($this->serviceName)->merge($healthcheckConfig);
        }
    }

    private function importRoutes(Config $config)
    {
        $healthcheckConfig = $config->get($this->serviceName);

        $routes = [
            [
                'class'   => 'Chocofamily\PhalconHealthCheck\Controllers\HealthCheckController',
                'methods' => [
                    'get' => [
                        $healthcheckConfig->get('routesimple')   => [
                            'action' => 'simple',
                            'name'   => 'chocofamily-healthcheck',
                        ],
                        $healthcheckConfig->get('routeextendet') => [
                            'action' => 'extendet',
                            'name'   => 'chocofamily-healthchec-extendet',
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
                    $collection->$verb($endpoint, $action['action'], $action['name']);
                }
            }

            $this->getApp()->mount($collection);
        }
    }

    /**
     * @return mixed
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param mixed $app
     */
    public function setApp($app): void
    {
        $this->app = $app;
    }
}
