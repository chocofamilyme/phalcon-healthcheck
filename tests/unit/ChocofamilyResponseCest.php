<?php

class ChocofamilyResponseCest
{
    /**
     * @dataProvider simpleResponseProvider
     *
     * @param UnitTester           $I
     * @param \Codeception\Example $data
     *
     * @throws JsonException
     */
    public function tryToSimpleResponse(UnitTester $I, \Codeception\Example $data): void
    {
        $I->wantToTest('метод Simple');

        $checks   = $data['checks'];
        $response = new \Chocofamily\PhalconHealthCheck\Responses\Response();
        $actual   = $response->simpleResponse($checks);
        $expected = $data['expected'];

        $I->assertEquals(\json_encode($expected, JSON_THROW_ON_ERROR), $actual->getContent());
    }

    /**
     * @return array
     */
    protected function simpleResponseProvider()
    {
        return [
            [
                'checks'   =>
                    [
                        'DB' => ['status' => true, 'message' => null],
                    ],
                'expected' =>
                    [
                        'data' => ['DB' => 'OK'],
                    ],
            ],
            [
                'checks'   =>
                    [
                        'DB' => ['status' => false, 'message' => 'something wrong'],
                    ],
                'expected' =>
                    [
                        'data' => ['DB' => 'CRITICAL'],
                    ],
            ],
        ];
    }

    /**
     * @dataProvider extendedResponseProvider
     *
     * @param UnitTester           $I
     * @param \Codeception\Example $data
     */
    public function tryToExtendedResponse(UnitTester $I, \Codeception\Example $data): void
    {
        $I->wantToTest('метод extended');

        $checks   = $data['checks'];
        $response = new \Chocofamily\PhalconHealthCheck\Responses\Response();
        $actual   = $response->extendedResponse($checks);
        $expected = $data['expected'];

        $I->assertEquals(\json_encode($expected, JSON_THROW_ON_ERROR), $actual->getContent());
    }

    /**
     * @return array
     */
    protected function extendedResponseProvider()
    {
        return [
            [
                'checks'   =>
                    [
                        'DB' => ['status' => true, 'message' => null],
                    ],
                'expected' =>
                    [
                        'data' => ['DB' => ['STATUS' => 'OK', 'STATUS_BOOL' => true, 'MESSAGE' => null]],
                    ],
            ],
            [
                'checks'   =>
                    [
                        'DB' => ['status' => false, 'message' => 'something wrong'],
                    ],
                'expected' =>
                    [
                        'data'
                        => [
                            'DB' => [
                                'STATUS'      => 'CRITICAL',
                                'STATUS_BOOL' => false,
                                'MESSAGE'     => 'something wrong',
                            ],
                        ],
                    ],
            ],
        ];
    }

}
