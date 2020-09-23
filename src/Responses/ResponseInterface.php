<?php

namespace Chocofamily\PhalconHealthCheck\Responses;

interface ResponseInterface
{
    public function simpleResponse(array $checks);
    public function extendedResponse(array $checks);
}
