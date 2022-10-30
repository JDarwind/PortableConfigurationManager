<?php

namespace Jdarwind\PortableConfigurationManager;

class ConfigurationObject
{
    protected string $arraySeparatorChar = '.';
    protected array $configurations = [];
    protected bool $throwErrors;
    protected array $errors = [];

    public function __construct(array $configurations = [], string $arraySeparatorChar = ".", bool $throwErrors = false ) {
        $this->configurations = $configurations;
        $this->arraySeparatorChar = $arraySeparatorChar;
        $this->throwErrors = $throwErrors;
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
    public function getErrors(){
        return $this->errors;
    }
    public function resetErrors(){
        $this->errors = [];
        return $this;
    }

    public function useErrors(bool $useErrors){
        $this->throwErrors = $useErrors;
        return $this;
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
    function recursive_set(&$arr, $path, $data, $lastkey = null){
        if(is_array($arr) && array_key_exists($path[0], $arr)){
            foreach($arr as $key => &$value){
                if($path[0] == $key){
                    if(is_array($value)){
                        $lastKey =$path[array_key_first($path)];
                        array_shift($path);
                        return $this->recursive_set($value, $path, $data, $lastKey);
                    }else{
                        $value = $data;
                        return  $value;
                    }
                }
            }
        }else{

            if(is_array($path)){

                if(count($path) > 1){
                    $lastKey = $path[array_key_first($path)];
                    $arr[$path[0]] = [];
                    array_shift($path);
                    return $this->recursive_set($arr[$lastKey], $path, $data);
                }
                else{
                    $arr[$path[0]] = $data;
                    return $arr[$path[0]];
                }
            }else{
                $arr[$path] = $data;
                return $arr[$path[0]];
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