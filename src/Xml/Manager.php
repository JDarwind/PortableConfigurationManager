<?php
namespace Jdarwind\PortableConfigurationManager\Xml;

use Jdarwind\PortableConfigurationManager\AbstractManager;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotFoundException;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;

class Manager extends AbstractManager{

    /**
     * @throws ConfigurationFileNotFoundException
     * @throws ConfigurationFileNotSupportedException
     */
    public function load(string $filePath){
        if(!\file_exists($filePath)){
            throw new ConfigurationFileNotFoundException($filePath);
        }
        \libxml_use_internal_errors(true);
        $xmlData = \simplexml_load_file($filePath);
        if($xmlData == false){
            throw new ConfigurationFileNotSupportedException($filePath);
        }

        $tmp = json_decode(json_encode($xmlData),true);

        if(!json_last_error() == JSON_ERROR_NONE){
            throw new ConfigurationFileNotSupportedException($filePath);
        } 
        $this->configurations = $tmp;
        $this->ConfigurationStorage = $this->buildConfigurationObject();
        return $this;
    }
}