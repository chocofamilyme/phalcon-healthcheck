<?php

namespace Chocofamily\PhalconHealthCheck\Responses;

use JsonException;
use \Phalcon\Http\Response as PhalconResponse;

use function json_encode;

class Response implements ResponseInterface
{
    protected const OK       = 'OK';
    protected const CRITICAL = 'CRITICAL';

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
        foreach ($checks as $checkTitle => $check) {
            if ($check['status']) {
                $responseArray[$checkTitle] = self::OK;
            } else {
                $responseArray[$checkTitle] = self::CRITICAL;
            }
        }

        return $this->response($responseArray);
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
            }
        }

        return $this->response($responseArray);
    }


    /**
     * @param array $responseArray
     *
     * @return PhalconResponse
     * @throws JsonException
     */
    private function response(array $responseArray): PhalconResponse
    {
        $content = json_encode(
            [
                'data' => $responseArray,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = new PhalconResponse($content);

        $response->setHeader('Content-Type', 'application/json');

        return $response;
    }
}
