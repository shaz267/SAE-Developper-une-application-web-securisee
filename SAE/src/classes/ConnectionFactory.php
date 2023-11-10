<?php
namespace touiteur\classes;

use PDO;

/**
 * Class ConnectionFactory, qui permet de se connecter à la base de données
 * @package touiteur\classes
 */
class ConnectionFactory
{
    /**
     * @var array $config Tableau contenant les paramètres de connexion à la base de données
     */
    public static $config = [];

    /**
     * Fonction qui permet de récupérer les paramètres de connexion à la base de données
     * @param $file
     * @return void
     */
    public static function setConfig($file)
    {
        self::$config = parse_ini_file($file);
    }

    /**
     * Fonction qui permet de se connecter à la base de données
     * @return PDO, la connexion
     */
    static function makeConnection(): PDO
    {

        $dsn = 'mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['dbname'];
        $user = self::$config['user'];
        $password = self::$config['password'];

        return new PDO($dsn, $user, $password);
    }
}