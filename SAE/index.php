<?php

require_once 'vendor/autoload.php';

use touiteur\classes\ConnectionFactory;
use touiteur\classes\Dispatcher;

//: Initialiser la connexion à la base de données
ConnectionFactory::setConfig('db_config.ini');

//: Lancer le dispatcher
$dispatcher = new Dispatcher();
$dispatcher->run();