<?php

use Phalcon\Config;

class ConfigCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToMergePackageConfig(UnitTester $I)
    {
        $I->wantToTest('Объединить конфигурацию пакета healthcheck.php, если проекте такого нет');

        $di                = \Phalcon\Di::getDefault();
        $config            = $di->get('config');
        $healthcheckConfig = $config->get('healthcheck');
        $I->assertNull($healthcheckConfig);

        $serviceProvider = new \Chocofamily\PhalconHealthCheck\Providers\HealthCheckServiceProvider();
        $serviceProvider->mergePackageConfig($config);
        $healthcheckConfig = $config->get('healthcheck');
        $I->assertNotNull($healthcheckConfig);
    }
}
