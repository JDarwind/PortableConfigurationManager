<?php

namespace Jdarwind\PortableConfigurationManager\Array\Immutable;

use Jdarwind\PortableConfigurationManager\Array\AbstractManager;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotFoundException;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;
use Jdarwind\PortableConfigurationManager\Exception\ImmutableDataChangeNotAllowedException;
use Jdarwind\PortableConfigurationManager\Exception\ImmutableSerializationNotAllowedException;

class Manager extends AbstractManager
{
    public function __construct(bool $throwErrors = true, string $arraySeparatorChar = '.')
    {
        parent::__construct($throwErrors, $arraySeparatorChar);
    }

    /**
     * @throws ConfigurationFileNotFoundException
     * @throws ConfigurationFileNotSupportedException
     * @throws \Throwable
     */
    public function load(string $filePath)
    {
        return parent::_load($filePath);
    }

    /**
     * @throws ImmutableSerializationNotAllowedException
     */
    public function serialize(array $params = [])
    {
        throw new ImmutableSerializationNotAllowedException();
    }
    public function set(string $name, mixed $data, bool $returnSetValue = true, bool $blindReturn = false)
    {
        throw new ImmutableDataChangeNotAllowedException();
    }
}