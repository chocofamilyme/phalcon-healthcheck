<?php
namespace Chocofamily\PhalconHealthCheck\Providers;

use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use RestAPI\Providers\AbstractServiceProvider;

class HealthCheckServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     *
     * @var string
     */
    protected $serviceName = 'healthCheck';

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $di = Di::getDefault();
        $config = $di->get('config');
        $node = 'healthcheck';

        if(!$config->offsetExists($node)) {
            $healthcheckConfig = include('/srv/www/app/vendor/chocofamilyme22/phalcon-healthcheck/healthcheck.php');
            $healthcheckConfig = new Config($healthcheckConfig);
            $config->offsetSet($node, new Config());
            $config->get($node)->merge($healthcheckConfig);
        }

        $routes = [
            [
                'class' => 'Chocofamily\PhalconHealthCheck\Controllers\HealthCheckController',
                'methods' => [
                    'get' => [
                        config('healthcheck.routesimple') => [
                            'action' => 'simple'
                        ],
                        config('healthcheck.routeextendet') => [
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
