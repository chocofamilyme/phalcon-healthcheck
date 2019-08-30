<?php
namespace Chocofamily\PhalconHealthCheck\Providers;

use Phalcon\Config;
use Phalcon\Di;
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

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $di = Di::getDefault();
        $config = $di->get('config');
        $this->mergePackageConfig($config);
        $this->importRoutes($config);
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

    public function mergePackageConfig(Config &$config)
    {
        if (!$config->offsetExists($this->serviceName)) {
            $healthcheckArray = include(__DIR__.'/../../healthcheck.php');
            $healthcheckConfig = new Config($healthcheckArray);
            $config->offsetSet($this->serviceName, new Config());
            $config->get($this->serviceName)->merge($healthcheckConfig);
        }
        //var_dump($config);
    }

    private function importRoutes(Config $config)
    {
        $healthcheckConfig = $config->get($this->serviceName);

        $routes = [
            [
                'class' => 'Chocofamily\PhalconHealthCheck\Controllers\HealthCheckController',
                'methods' => [
                    'get' => [
                        $healthcheckConfig->get('routesimple') => [
                            'action' => 'simple'
                        ],
                        $healthcheckConfig->get('routeextendet') => [
                            'action' => 'extendet'
                        ]
                    ]
                ]
            ]
        ];

        foreach ($routes as $route) {
            $collection = new MicroCollection();
            $collection->setHandler($route['class'], true);

            foreach ($route['methods'] as $verb => $methods) {
                foreach ($methods as $endpoint => $action) {
                    $params = isset($action['params']) ? $action['params'] : [];
                    $collection->$verb($endpoint, $action['action'], $params);
                }
            }

            $this->getDI()->get('bootstrap')->getApplication()->mount($collection);
        }
    }

}
