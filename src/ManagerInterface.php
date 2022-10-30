<?php

namespace Jdarwind\PortableConfigurationManager;

interface ManagerInterface
{
    public function load(string $filePath);
    public function serialize(array $params = []);
}