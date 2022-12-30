<?php

namespace Jdarwind\PortableConfigurationManager\Array;

use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;

abstract class AbstractManager extends \Jdarwind\PortableConfigurationManager\AbstractManager
{

    protected  function _load(string $filePath){
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
}