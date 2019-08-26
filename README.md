# Phalcon Health Check Library
Health Check library adds new endpoints(routes) to your project which are used to check some services of your application.
For example you want to check "Database Connection" of your microservice.

# Installation
```bash
composer require chocofamilyme/phalcon-healthcheck ^0.0
```
- Add app/provider/HealthCheck/ServiceProvider.php with this content as an example:
```bash
<?php
namespace RestAPI\Providers\HealthCheck;

use Chocofamily\PhalconHealthCheck\Providers\HealthCheckServiceProvider;

// Use your own ServiceProviderIntreface
use RestAPI\Providers\ServiceProviderInterface;

class ServiceProvider extends HealthCheckServiceProvider implements ServiceProviderInterface
{

}
```
- Copy healthcheck.php to config and manage the necessary configuration values for the project

# Checks
- Database connection check
- Cache write&read check
- Sessions write&read check
- Storage check

# Routes
- /health
```json
{
  "DB": "OK",
  "CACHE": "OK",
  "SESSIONS": "CRITICAL",
  "STORAGE": "OK"
}
```
- /health/extendet
```json
{
  "DB": {
    "STATUS": "OK",
    "STATUS_BOOL": true,
    "MESSAGE": null
  },
  "CACHE": {
    "STATUS": "OK",
    "STATUS_BOOL": true,
    "MESSAGE": null
  },
  "SESSIONS": {
    "STATUS": "CRITICAL",
    "STATUS_BOOL": false,
    "MESSAGE": "Connection to tarantool.example.com failed"
  },
  "STORAGE": {
    "STATUS": "OK",
    "STATUS_BOOL": true,
    "MESSAGE": null
  }
}
```

# How to write your custom checks
Create a class which implements Chocofamily\PhalconHealthCheck\Services\Checks\ComponentCheckInterface
and add it to healthcheck.php config file like
```php
return [
    'componentChecks' => [
        'YOURCUSTOMCHECK' => YourCustomCheck::class
    ]
]
```

# Responses
There is a configuration param which describes which response class to use to output the response. For example
- /health - Chocofamily\PhalconHealthCheck\Responses\ChocofamilyResponse::class
output would look like this
```json
{
    "error_code": 0,
    "status": "success",
    "message": "Everything is fine",
    "data": {
        "DB": "OK",
        "CACHE": "OK",
        "SESSIONS": "CRITICAL",
        "STORAGE": "OK"
    }
}
```

Feel free to add your responses, if you want for example to output it in a view instead json.
