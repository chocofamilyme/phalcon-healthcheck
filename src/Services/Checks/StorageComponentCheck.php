<?php

declare(strict_types=1);

namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Chocofamily\PhalconHealthCheck\Services\DefaultHealthCheckConfigService;
use Phalcon\Di\DiInterface;
use Phalcon\Text;
use RuntimeException;

class StorageComponentCheck implements ComponentCheckInterface
{
    private DiInterface $di;

    public function register(DiInterface $di): void
    {
        $this->di = $di;
    }

    public function check(): void
    {
        $healthCheckConfig               = $this->di->get('config')->get('healthcheck');
        $defaultHealthCheckConfigService = new DefaultHealthCheckConfigService();

        $storagePath = $healthCheckConfig->get('storagePath', $defaultHealthCheckConfigService->get('storagePath'));
        $storageDirs = $healthCheckConfig->get('storageDirs', $defaultHealthCheckConfigService->get('storageDirs'));

        if (!is_dir($storagePath)) {
            throw new RuntimeException("Invalid storage path specified, please configure it");
        }

        $fileName = 'healthcheck_'.Text::random(Text::RANDOM_ALNUM, 10);
        $text     = 'some text';

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

    private function write(string $file, string $text): bool
    {
        return file_put_contents($file, $text) !== false;
    }

    private function delete(string $file): bool
    {
        return unlink($file);
    }
}
