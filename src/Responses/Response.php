<?php

namespace Chocofamily\PhalconHealthCheck\Responses;

use JsonException;
use \Phalcon\Http\Response as PhalconResponse;

use function json_encode;

class Response implements ResponseInterface
{
    protected const OK                  = 'OK';
    protected const CRITICAL            = 'CRITICAL';
    protected const HTTP_STATUS_SUCCESS = 200;
    protected const HTTP_STATUS_FAIL    = 503;

    /**
     * Return data in a simple way
     *
     * @param array $checks
     *
     * @return PhalconResponse
     * @throws JsonException
     */
    public function simpleResponse(array $checks): PhalconResponse
    {
        $responseArray = [];
        $httpStatus    = self::HTTP_STATUS_SUCCESS;
        foreach ($checks as $checkTitle => $check) {
            if ($check['status']) {
                $responseArray[$checkTitle] = self::OK;
            } else {
                $responseArray[$checkTitle] = self::CRITICAL;
                $httpStatus                 = self::HTTP_STATUS_FAIL;
            }
        }

        return $this->response($responseArray, $httpStatus);
    }

    /**
     * Return data in extended way
     *
     * @param array $checks
     *
     * @return PhalconResponse
     * @throws JsonException
     */
    public function extendedResponse(array $checks): PhalconResponse
    {
        $responseArray = [];
        $httpStatus    = self::HTTP_STATUS_SUCCESS;
        foreach ($checks as $checkTitle => $check) {
            if ($check['status']) {
                $responseArray[$checkTitle] = [
                    'STATUS'      => self::OK,
                    'STATUS_BOOL' => true,
                    'MESSAGE'     => $check['message'],
                ];
            } else {
                $responseArray[$checkTitle] = [
                    'STATUS'      => self::CRITICAL,
                    'STATUS_BOOL' => false,
                    'MESSAGE'     => $check['message'],
                ];
                $httpStatus                 = self::HTTP_STATUS_FAIL;
            }
        }

        return $this->response($responseArray, $httpStatus);
    }


    /**
     * @param array $responseArray
     *
     * @param int   $httpStatus
     *
     * @return PhalconResponse
     * @throws JsonException
     */
    private function response(array $responseArray, int $httpStatus = self::HTTP_STATUS_SUCCESS): PhalconResponse
    {
        $content = json_encode(
            [
                'data' => $responseArray,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = new PhalconResponse($content);

        $response->setHeader('Content-Type', 'application/json');
        $response->setStatusCode($httpStatus);

        return $response;
    }
}
