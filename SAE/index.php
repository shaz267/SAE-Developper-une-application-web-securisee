<?php

require_once 'vendor\autoload.php';

use touiteur\classes\ConnectionFactory;
use touiteur\classes\Dispatcher;

ConnectionFactory::setConfig('db_config.ini');

$dispatcher = new Dispatcher();
$dispatcher->run();