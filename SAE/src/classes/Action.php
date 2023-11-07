<?php

namespace SAE\src\classes;
abstract class Action
{

    protected $http_method = null;
    protected $hostname = null;
    protected $script_name = null;

    public function __construct()
    {

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    abstract public function execute(): string;
}