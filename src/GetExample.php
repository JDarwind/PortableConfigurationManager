<?php

use Jdarwind\PortableConfigurationManager\ConfigurationObject;

$ConfigurationObj = new ConfigurationObject([
                            'demo_prop' => 'demo_value'
                        ],
                        '.',
                    );
$value = $ConfigurationObj->get('demo_prop');
?>