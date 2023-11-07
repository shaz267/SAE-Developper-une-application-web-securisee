<?php

require_once 'vendor\autoload.php';

use touiteur\classes\ConnectionFactory;

ConnectionFactory::setConfig('db_config.ini');

$pdo = ConnectionFactory::makeConnection();

echo "Connexion réussie !";