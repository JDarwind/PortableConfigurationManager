<?php

namespace Jdarwind\PortableConfigurationManager\Xml\Immutable;

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
     */
    public function load(string $filePath)
    {

        try {
            $filePath = $this->getPath($filePath);
            \libxml_use_internal_errors(false);
            $buffer = file_get_contents($filePath);

            $xmlData = \simplexml_load_string($buffer);
            if ($xmlData == false) {
                throw new ConfigurationFileNotSupportedException($filePath);
            }

            $tmp = json_decode(json_encode($xmlData), true);

            if (!json_last_error() == JSON_ERROR_NONE) {
                throw new ConfigurationFileNotSupportedException($filePath);
            }
            $this->configurations = $tmp;
            $this->ConfigurationStorage = $this->buildConfigurationObject();
        }catch (\Exception|\Throwable $e){
            if($this->throwErrors){
                throw $e;
            }
            $this->errors[] = $e;
        }
        return $this;
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