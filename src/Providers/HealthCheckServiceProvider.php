<?php
namespace Chocofamily\PhalconHealthCheck\Providers;

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
