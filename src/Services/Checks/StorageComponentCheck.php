<?php


namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Chocofamily\PhalconHealthCheck\Services\HealthcheckDefaultConfigService;
use Phalcon\Di;
use RuntimeException;

class StorageComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $healthcheckConfig = Di::getDefault()->get('config')->get('healthcheck');
        $healthcheckDefaultConfigService = new HealthcheckDefaultConfigService();

        $storagePath = $healthcheckConfig->get('storagepath', $healthcheckDefaultConfigService->get('storagepath'));
        $storageDirs = $healthcheckConfig->get('storagedirs', $healthcheckDefaultConfigService->get('storagedirs'));

        if (!is_dir($storagePath)) {
            throw new RuntimeException("Invalid storage path specified, please configure it");
        }

        $fileName = 'healthcheck.txt';
        $text = 'some data';

        foreach ($storageDirs as $storageDir) {
            $dir = $storagePath.$storageDir;
            if (!is_dir($dir)) {
                continue;
            }

            $file = $dir.$fileName;
            if ($this->write($file, $text) === false) {
                throw new RuntimeException("Failed to write to $file");
            }
            $this->delete($file);
        }
    }

    private function write($file, $text)
    {
        return file_put_contents($file, $text) !== false;
    }

    private function delete($file)
    {
        return unlink($file);
    }
}
