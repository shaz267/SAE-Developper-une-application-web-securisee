<?php

use Action\TouitesAction;
require_once 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

class Dispatcher
{

    private $action;

    public function __construct()
    {
        $this->action = $_GET['action'];
    }

    public function run(){

        switch ($this->action){
            case '':

                break;
            default:
                $this->executeAction(new DefaultAction());

        }
    }

}