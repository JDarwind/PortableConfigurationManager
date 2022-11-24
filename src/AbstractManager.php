<?php

namespace Jdarwind\PortableConfigurationManager;

use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotFoundException;

abstract class AbstractManager implements ManagerInterface {
    protected ConfigurationObject|null $ConfigurationStorage = null;
    protected string $arraySeparatorChar = '.';
    public array $configurations = [];
    protected bool $throwErrors = true;
    protected array $errors = [];

    public function __construct(bool $throwErrors = true, string $arraySeparatorChar = '.'){
        $this->throwErrors = $throwErrors;
        $this->arraySeparatorChar = $arraySeparatorChar;
    }
    protected function buildConfigurationObject(): ConfigurationObject{
        return (new ConfigurationObject($this->configurations, $this->arraySeparatorChar));
    }
    public function get(string $name = ''){
        return $this->ConfigurationStorage->get();
    }
    public function set(string $name , mixed $data, bool $returnSetValue = true, bool $blindReturn = false){
        $returner = $this->ConfigurationStorage->set($name, $data, $returnSetValue);

        if($returnSetValue){
            if($blindReturn){
               return $returner;
            }else{
                if($returner instanceof ConfigurationObject){
                    return $this;
                }else{
                    return $returner;
                }
            }
        }else{
            return $this;
        }

    }
    public function getPath(string $filePath)
    {
        $file = false;
        if(realpath($filePath)){
            $file = realpath($filePath);
        }else{
            $backtrace = \debug_backtrace()[1]['file'];
            $file =  realpath(dirname($backtrace)). DIRECTORY_SEPARATOR . $filePath;
        }

        if (!$file || !\file_exists($file)) {
            throw new ConfigurationFileNotFoundException($file);
        }
        return $file;
    }

}