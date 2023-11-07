<?php
declare(strict_types=1);

spl_autoload_register(function ($class_name) {

    echo $class_name . "<br>";

    $class_name = str_replace('\\', '/', $class_name);

    echo $class_name;

    require_once('../' . $class_name . '.php');
});