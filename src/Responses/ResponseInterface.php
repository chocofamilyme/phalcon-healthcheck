<?php

namespace Chocofamily\PhalconHealthCheck\Responses;

interface ResponseInterface
{
    /**
     * @param array $checks
     */
    public function simpleResponse(array $checks);

    /**
     * @param array $checks
     */
    public function extendetResponse(array $checks);
}
