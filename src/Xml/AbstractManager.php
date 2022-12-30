<?php

namespace Jdarwind\PortableConfigurationManager\Xml;

use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;

abstract class AbstractManager extends \Jdarwind\PortableConfigurationManager\AbstractManager
{
    protected function _load(string $filePath): AbstractManager
    {

        try {
            $filePath = $this->getPath($filePath);
            \libxml_use_internal_errors(false);
            $buffer = file_get_contents($filePath);

            $xmlData = \simplexml_load_string($buffer);
            if ($xmlData === false) {
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
}