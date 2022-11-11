<?php

namespace Jdarwind\PortableConfigurationManager;
class Factory
{
    public static function make($type): ManagerInterface|null{
        $instance = null;
        $namespace = __NAMESPACE__;
        $instanceNamespace = sprintf('%s\\%s\Manager', $namespace, $type);
        if(class_exists($instanceNamespace)) {
            $instance = new $instanceNamespace;
        }
        return $instance;
    }
}