<?php

class ChocofamilyResponseCest
{
    public function _before(UnitTester $I)
    {
    }

    /**
     * @dataProvider simpleResponseProvider
     *
     * @param UnitTester           $I
     * @param \Codeception\Example $data
     */
    public function tryToSimpleResponse(UnitTester $I, \Codeception\Example $data)
    {
        $I->wantToTest('метод Simple');

        $checks   = $data['checks'];
        $response = new \Chocofamily\PhalconHealthCheck\Responses\ChocofamilyResponse();
        $actual   = $response->simpleResponse($checks);
        $expected = $data['expected'];

        $I->assertEquals($expected, $actual);
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
                        'error_code' => 0,
                        'status'     => 'success',
                        'message'    => 'Everything is fine',
                        'data'       => ['DB' => 'OK'],
                    ],
            ],
            [
                'checks'   =>
                    [
                        'DB' => ['status' => false, 'message' => 'something wrong'],
                    ],
                'expected' =>
                    [
                        'error_code' => 500,
                        'status'     => 'error',
                        'message'    => 'There are some critical checks',
                        'data'       => ['DB' => 'CRITICAL'],
                    ],
            ],
        ];
    }

    /**
     * @dataProvider extendetResponseProvider
     *
     * @param UnitTester           $I
     * @param \Codeception\Example $data
     */
    public function tryToExtendetResponse(UnitTester $I, \Codeception\Example $data)
    {
        $I->wantToTest('метод Extendet');

        $checks   = $data['checks'];
        $response = new \Chocofamily\PhalconHealthCheck\Responses\ChocofamilyResponse();
        $actual   = $response->extendetResponse($checks);
        $expected = $data['expected'];

        $I->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    protected function extendetResponseProvider()
    {
        return [
            [
                'checks'   =>
                    [
                        'DB' => ['status' => true, 'message' => null],
                    ],
                'expected' =>
                    [
                        'error_code' => 0,
                        'status'     => 'success',
                        'message'    => 'Everything is fine',
                        'data'       => ['DB' => ['STATUS' => 'OK', 'STATUS_BOOL' => true, 'MESSAGE' => null]],
                    ],
            ],
            [
                'checks'   =>
                    [
                        'DB' => ['status' => false, 'message' => 'something wrong'],
                    ],
                'expected' =>
                    [
                        'error_code' => 500,
                        'status'     => 'error',
                        'message'    => 'There are some critical checks',
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
