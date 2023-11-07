<?php

require_once '..\vendor\autoload.php';

use src\classes\ConnectionFactory;

ConnectionFactory::setConfig('config.ini');

$pdo = ConnectionFactory::makeConnection();

echo "Connexion réussie !";