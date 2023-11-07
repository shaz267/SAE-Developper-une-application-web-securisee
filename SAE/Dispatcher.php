<?php

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