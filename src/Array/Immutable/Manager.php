<?php

namespace Jdarwind\PortableConfigurationManager\Array\Immutable;

use Jdarwind\PortableConfigurationManager\AbstractManager;
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
        try {
            $filePath = $this->getPath($filePath);
            $data = include $filePath;

            if (!is_array($data)) {
                throw new ConfigurationFileNotSupportedException($filePath);
            }
            foreach ($data as $key => $value) {
                $this->configurations[$key] = $value;
            }
        } catch (\Exception|\Throwable $e){
            if($this->throwErrors){
                throw $e;
            }
            $this->errors[] = $e;
        }
        $this->ConfigurationStorage = $this->buildConfigurationObject();
        return $this;
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