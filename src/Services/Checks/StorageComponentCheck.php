<?php


namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use RuntimeException;

class StorageComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $storagePath = '../storage/';

        $file = $storagePath.'app/healthcheck.txt';
        if(!file_put_contents($file, 'randomText')) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);

        $file = $storagePath.'cache/healthcheck.txt';
        if(!file_put_contents($file, 'randomText')) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);

        $file = $storagePath.'logs/healthcheck.txt';
        if(!file_put_contents($file, 'randomText')) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);
    }
}
