<?php

namespace Jdarwind\PortableConfigurationManager\Exception;

class ConfigurationFileNotFoundException extends \Exception
{
    public function __construct($filePath, $code = 0, \Throwable $previous = null) {
        $message = sprintf("Configuration file %s not found", $filePath);
        parent::__construct($message, $code, $previous);
    }
}