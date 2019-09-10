<?php


namespace Chocofamily\PhalconHealthCheck\Services\Checks;

use Phalcon\Text;
use RuntimeException;

class StorageComponentCheck implements ComponentCheckInterface
{
    public function check()
    {
        $storagePath = '../storage/';
        $fileName = Text::random();
        $text = Text::random();

        $file = $storagePath.'app/'.$fileName;
        if(!file_put_contents($file, $text)) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);

        $file = $storagePath.'cache/'.$fileName;
        if(!file_put_contents($file, $text)) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);

        $file = $storagePath.'logs/'.$fileName;
        if(!file_put_contents($file, $text)) {
            throw new RuntimeException("Failed to write to $file");
        }
        unlink($file);
    }
}
