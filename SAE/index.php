<?php

require_once 'vendor\autoload.php';

use touiteur\classes\ConnectionFactory;

ConnectionFactory::setConfig();

$pdo = ConnectionFactory::makeConnection();

echo "Connexion réussie !";