<?php

namespace Jdarwind\PortableConfigurationManager\Exception;

class ImmutableDataChangeNotAllowedException extends \Exception
{
    public function __construct( $code = 0, \Throwable $previous = null) {
        $message = sprintf("Data Modification is Not Allowed In Immutable Objects");
        parent::__construct($message, $code, $previous);
    }
}