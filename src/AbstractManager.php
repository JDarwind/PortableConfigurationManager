<?php

namespace Jdarwind\PortableConfigurationManager;

abstract class AbstractManager implements ManagerInterface {
    protected ConfigurationObject|null $ConfigurationStorage = null;
    protected string $arraySeparatorChar = '.';
    protected array $configurations = [];
    protected bool $throwErrors = false;
    protected array $errors = [];

    const ACCESS_LEVEL_PUBLIC = 0, ACCESS_LEVEL_RESTRICTED = 1;

    public function __construct(bool $throwErrors = false, string $arraySeparatorChar = '.'){
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

}