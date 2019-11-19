<?php

use Helper\Mock\CriticalComponentCheck;
use Helper\Mock\OkComponentCheck;

class ComponentCheckServiceCest
{
    public function _before(UnitTester $I)
    {
    }

    /**
     * @dataProvider componentCheckProvider
     *
     * @param UnitTester           $I
     * @param \Helper\Unit         $helper
     * @param \Codeception\Example $data
     *
     * @throws ReflectionException
     */
    public function tryToGetStatus(UnitTester $I, \Helper\Unit $helper, \Codeception\Example $data)
    {
        $I->wantToTest('метод getStatus');

        $check = new $data['check'];
        $componentCheckService = new \Chocofamily\PhalconHealthCheck\Services\ComponentCheckService();
        $actual = $helper->invokeMethod($componentCheckService, 'getStatus', [$check]);
        $expected = $data['expected'];

        $I->assertEquals($expected, $actual);
    }

    protected function componentCheckProvider()
    {
        return [
            [
                'check' => OkComponentCheck::class,
                'expected' => [
                    'status' => true,
                    'message' => null
                ]
            ],
            [
                'check' => CriticalComponentCheck::class,
                'expected' => [
                    'status' => false,
                    'message' => 'Critical Exception'
                ]
            ]
        ];
    }
}