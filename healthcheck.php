<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Route for the simple response
    |--------------------------------------------------------------------------
    |
    | Specify route for the simple response
    |
    */

    'route' => '/health',

    /*
    |--------------------------------------------------------------------------
    | Route for the extended response
    |--------------------------------------------------------------------------
    |
    | Specify route for the extended response
    |
    */

    'routeExtended' => '/health/extended',

    /*
    |--------------------------------------------------------------------------
    | Response class
    |--------------------------------------------------------------------------
    |
    | Describes which response class to use to output the response.
    | Feel free to add your own response class, it should implement
    | Chocofamily\PhalconHealthCheck\Responses\ResponseInterface
    |
    */

    'response' => Chocofamily\PhalconHealthCheck\Responses\Response::class,

    /*
    |--------------------------------------------------------------------------
    | Enable extended health check endpoint
    |--------------------------------------------------------------------------
    |
    | Enable extended endpoint for healthchecks with more information what
    | went wrong, this is dangerous because in the exception messages may be
    | confidential information
    |
    */

    'extended' => false,

    /*
    |--------------------------------------------------------------------------
    | Storage path
    |--------------------------------------------------------------------------
    |
    | Specify storage path
    |
    */

    'storagePath' => '../storage/',

    /*
    |--------------------------------------------------------------------------
    | Storage directories
    |--------------------------------------------------------------------------
    |
    | Specify storage directories, example: 'logs/' (use a slash at the end)
    |
    */

    'storageDirs' => ['', ],

    /*
    |--------------------------------------------------------------------------
    | Component checks
    |--------------------------------------------------------------------------
    |
    | This array should contain all component check classes which are needet
    | to check some application functionality, e.g. like Database, Cache
    | or Sessions etc.
    | Feel free to add more. All of your component checks should implement
    | Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface
    |
    */

    'componentChecks' => [
        'DB'       => Chocofamily\PhalconHealthCheck\Services\Checks\DatabaseComponentCheck::class,
        'CACHE'    => Chocofamily\PhalconHealthCheck\Services\Checks\CacheComponentCheck::class,
        //'SESSIONS' => Chocofamily\PhalconHealthCheck\Services\Checks\SessionsComponentCheck::class,
        'STORAGE'  => Chocofamily\PhalconHealthCheck\Services\Checks\StorageComponentCheck::class,
    ]
];
