<?php

namespace Jdarwind\PortableConfigurationManager\Exception;

class ConfigurationFileNotSupportedException extends \Exception
{
    public function __construct($filePath, $code = 0, \Throwable $previous = null) {
        $message = sprintf("Configuration file %s format not supported", $filePath);
        parent::__construct($message, $code, $previous);
    }
}