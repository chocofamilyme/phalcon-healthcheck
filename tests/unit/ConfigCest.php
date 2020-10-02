<?php

use Phalcon\Config;

class ConfigCest
{
    // tests
    /**
     * @param UnitTester   $I
     * @param \Helper\Unit $helper
     *
     * @throws ReflectionException
     */
    public function tryToMergePackageConfig(UnitTester $I, \Helper\Unit $helper)
    {
        $I->wantToTest('Объединить конфигурацию пакета healthCheck.php, если проекте такого нет');

        $config            = \Phalcon\Di::getDefault()->get('config');
        $healthCheckConfig = $config->get('healthCheck');
        $I->assertEmpty($healthCheckConfig);

        $serviceProvider = new \Chocofamily\PhalconHealthCheck\Providers\HealthCheckServiceProvider();

        $helper->invokeMethod($serviceProvider, 'mergePackageConfig', [&$config]);
        $healthCheckConfig = $config->get('healthCheck');
        $I->assertNotNull($healthCheckConfig);
    }
}
