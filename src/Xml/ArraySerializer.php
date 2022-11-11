<?php

namespace Jdarwind\PortableConfigurationManager\Xml;

class ArraySerializer
{

    public static function convert(\SimpleXMLElement $object, array $data, string|null $forcedName = null):void
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = current($object->xpath( 'parent::*' ))->children()->getName();
            }
            if($forcedName){
                $key = $forcedName;
            }
            if (is_array($value)) {
                $forceName = false;
                $arrayKeys = array_keys($value);
                foreach($arrayKeys as $tKey){
                    if(is_numeric($tKey)){
                        $forceName = true;
                    }
                }
                if(!$forceName){
                    $new_object = $object->addChild($key);
                    self::convert($new_object, $value);
                }else{
                    self::convert($object, $value, $key);
                }
            } else {
                $object->addChild($key, $value);
            }
        }
    }

}