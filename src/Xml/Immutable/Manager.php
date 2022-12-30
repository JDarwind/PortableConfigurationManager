<?php

namespace Jdarwind\PortableConfigurationManager\Xml\Immutable;

use Jdarwind\PortableConfigurationManager\Xml\AbstractManager;
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
        if($this->throwErrors){
            throw new ImmutableSerializationNotAllowedException();
        }
        $this->errors[] = (new ImmutableSerializationNotAllowedException());
    }
    public function set(string $name, mixed $data, bool $returnSetValue = true, bool $blindReturn = false)
    {
        if($this->throwErrors){
            throw new ImmutableDataChangeNotAllowedException();
        }
        $this->errors[] = (new ImmutableDataChangeNotAllowedException());
    }
}