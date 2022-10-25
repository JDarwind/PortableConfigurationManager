<?php

namespace Jdarwind\PortableConfigurationManager;

class ConfigurationObject
{
    protected string $arraySeparatorChar = '.';
    protected array $configurations = [];
    protected bool $throwErrors;

    public function __construct(array $configurations = [], string $arraySeparatorChar = ".", bool $throwErrors = false ) {
        $this->configurations = $configurations;
        $this->arraySeparatorChar = $arraySeparatorChar;
    }


    /**
     * This function provide easy access to the property stored in this configuration object.
     *
     * @param string $name
     * @return mixed
     * @throws \Throwable
     */
    public function get(string $name = ''):mixed{
        try {
            if ($name === '') {
                return $this->configurations;
            }
            $path = \explode($this->arraySeparatorChar, $name);
            return $this->recursive_get($this->configurations, $path);
        }catch (\Exception|\Throwable $e){
            if($this->throwErrors){
                throw $e;
            }
            $this->errors[] = $e;
        }
        return null;
    }

    /**
     * @throws \Throwable
     */
    public function set(string $name , mixed $data, bool $returnSetValue = true){
        try {
            $path = \explode($this->arraySeparatorChar, $name);
            if ($returnSetValue) {
                return $this->recursive_set($this->configurations, $path, $data);
            }
            $this->recursive_set($this->configurations, $path, $data);
        }catch (\Exception|\Throwable $e){
            if($this->throwErrors){
                throw $e;
            }
            $this->errors[] = $e;
        }
    }
    protected function recursive_set(&$arr, $path, $data){
        if(array_key_exists($path[0], $arr)){
            foreach($arr as $key => &$value){
                if($path[0] ==$key){
                    if(is_array($value)){
                        array_shift($path);
                        return $this->recursive_set($value, $path, $data);
                    }else{
                        $value = $data ;
                        return  $value;
                    }
                }
            }
        }else{
            if(is_array($path)){
                if(count($path) > 1){
                    $arr[$path[0]] = [];
                    array_shift($path);
                    return $this->recursive_set($arr, $path, $data);
                }
                else{
                    $arr[$path[0]] = $data;
                }
            }else{
                $arr[$path] = $data;
            }

        }

    }
    protected function recursive_get(&$arr, $path){

        foreach($arr as $key => &$value){

            if(is_array($path) && count($path)){
                if($path[0] == $key){
                    if(is_array($value)){
                        array_shift($path);
                        return $this->recursive_get($value, $path);
                    }else{
                        return  $value;
                    }
                }
            }else{
                if(is_array($arr)){
                    return $arr;
                }
                return $value;
            }

        }
    }

}