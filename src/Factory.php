<?php

namespace Jdarwind\PortableConfigurationManager;
class Factory
{
    /**
     * @throws \Exception
     */
    public static function make($type, array $args = []): ManagerInterface|null{
        $instance = null;
        $namespace = __NAMESPACE__;
        $instanceNamespace = sprintf('%s\\%s\Manager', $namespace, $type);
        if(class_exists($instanceNamespace)) {
            $reflection = new \ReflectionClass($instanceNamespace);
            $instance = $reflection->newInstanceArgs($args);
        }
        return $instance;
    }

    /**
     * @throws \Exception
     */
    public static function makeImmutable($type, array $args = []): ManagerInterface|null{
        $instance = null;
        $namespace = __NAMESPACE__;
        $instanceNamespace = sprintf('%s\\%s\Immutable\Manager', $namespace, $type);
        if(class_exists($instanceNamespace)) {
            $reflection = new \ReflectionClass($instanceNamespace);
            $instance = $reflection->newInstanceArgs($args);
        }
        return $instance;
    }
}