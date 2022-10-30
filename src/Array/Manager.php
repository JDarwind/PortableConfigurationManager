<?php

namespace Jdarwind\PortableConfigurationManager\Array;

use Jdarwind\PortableConfigurationManager\AbstractManager;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotFoundException;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;

class Manager extends AbstractManager
{

    /**
     * @throws ConfigurationFileNotFoundException
     * @throws ConfigurationFileNotSupportedException
     */
    public function load(string $filePath)
    {
        try {
            if (!\file_exists($filePath)) {
                throw new ConfigurationFileNotFoundException($filePath);
            }

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

    public function serialize(array $params = [])
    {
        // TODO: Implement serialize() method.
    }
}