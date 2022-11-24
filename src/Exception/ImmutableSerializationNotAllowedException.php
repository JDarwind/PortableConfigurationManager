<?php

namespace Jdarwind\PortableConfigurationManager\Exception;

class ImmutableSerializationNotAllowedException extends \Exception
{
    public function __construct( $code = 0, \Throwable $previous = null) {
        $message = sprintf("Serialization Not Allowed In Immutable Objects");
        parent::__construct($message, $code, $previous);
    }
}