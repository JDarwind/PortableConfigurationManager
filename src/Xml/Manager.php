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
        $filePath = __DIR__ . '/' . $filePath;
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

    public function serialize(array $params = []):string
    {
        $_data = [
            'fileName' => ""
        ];
        //parsing Params Array
        foreach ($params as $key => $value) {
            switch($key){
                case 'fileName':
                    $_data['fileName'] = $value;
                    break;
            }
        }
        $configArray = $this->ConfigurationStorage->get();

        $xmlObj = new \SimpleXMLElement('<configurations></configurations>');
        ArraySerializer::convert($xmlObj, $configArray);
        $dom = new \DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmlObj->asXML());
        $fileContent =  $dom->saveXML();
        $fileContent =  preg_replace_callback('/^( +)</m', function($a) {
            return str_repeat(' ',intval(strlen($a[1]) / 2) * 4).'<';
        }, $fileContent);
        $fileContent = preg_replace('/[\n]/',PHP_EOL,$fileContent);
        //Serializing on file
        if(isset($_data['fileName']) && is_string($_data['fileName']) && $_data['fileName'] ){
            $filePath = __DIR__ . '/' . $_data['fileName'];
            file_put_contents( $filePath, $fileContent);
            return $fileContent;
        }
        return $fileContent;
    }
}