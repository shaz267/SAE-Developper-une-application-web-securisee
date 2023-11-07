<?php

require_once '..\vendor\autoload.php';

use iutnc\touiteur\classes\ConnectionFactory;

ConnectionFactory::setConfig('config.ini');

$pdo = ConnectionFactory::makeConnection();

echo "Connexion réussie !";