<?php

namespace Jdarwind\PortableConfigurationManager\Xml;

class ArraySerializer
{

    public static function convert(\SimpleXMLElement $object, array $data, string|null $forcedName = null, array|null $attributes = []):void
    {

        foreach ($data as $key => $value) {

            if(is_array($attributes) && count($attributes)){
                foreach ($attributes as $attrKey => $attrData){
                    $object->addAttribute($attrKey, $attrData);
                }
            }
            if (is_numeric($key)) {
                $key = current($object->xpath( 'parent::*' ))->children()->getName();
            }
            if($forcedName){
                $key = $forcedName;
            }
            if (is_array($value)) {
                $forceName = false;
                $addAttributes = false;
                $_attributes = [];
                $arrayKeys = array_keys($value);
                foreach($arrayKeys as $tKey){
                    if(is_numeric($tKey)){
                        $forceName = true;
                    }
                    if(strpos($tKey, '@')>-1){
                        $addAttributes = true;
                        foreach ($value[$tKey] as $tempKey=>$tempValue){
                           $_attributes[$tempKey] = $tempValue;
                        }
                        unset($value[$tKey]);
                    }
                }
                if(!$forceName){
                    $new_object = $object->addChild($key);

                    if($addAttributes){
                        self::convert($new_object, $value, null, $_attributes);
                    }else{
                        self::convert($new_object, $value);
                    }
                }else{
                    if($addAttributes){
                        self::convert($object, $value, $key, $_attributes);
                    }else{
                        self::convert($object, $value, $key);
                    }

                }
            } else {
                $object->addChild($key, $value);
            }
        }
    }

}