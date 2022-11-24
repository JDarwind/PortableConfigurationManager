<?php

namespace Jdarwind\PortableConfigurationManager\Array;

use Jdarwind\PortableConfigurationManager\AbstractManager;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotFoundException;
use Jdarwind\PortableConfigurationManager\Exception\ConfigurationFileNotSupportedException;

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
        $_data = [
            'fileName' => ""
        ];
        //parsing Params Array
        foreach ($params as $key => $value) {
            switch($key){
                case 'fileName':
                        $_data['fileName'] =  $this->getPath($value);
                    break;
            }
        }

        $configArray = $this->ConfigurationStorage->get();
        //Serializing on file
        if(isset($_data['fileName']) && is_string($_data['fileName']) && $_data['fileName'] ){
            $fileContent = sprintf('<?php \n return %s \n ?>',var_export( $configArray, true ) );
            file_put_contents( $_data['fileName'], $fileContent);
            return $configArray;
        }
        return $configArray;
    }
}