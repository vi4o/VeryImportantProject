<?php
//autoload the classes
require "vendor/autoload.php";

//instantiate the DIC
$builder = new Aura\Di\ContainerBuilder();
$di = $builder->newConfiguredInstance(
    [
        //some di config
    ]
);