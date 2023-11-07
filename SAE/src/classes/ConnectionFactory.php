<?php
namespace iutnc\touiteur\classes\ConnectionFactory;
require_once '..\..\vendor\autoload.php';

use PDO;
class ConnectionFactory
{
    public static $config = [];

    public static function setConfig($file)
    {
        self::$config = parse_ini_file($file);
    }

    static function makeConnection(): PDO
    {

        $dsn = 'mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['dbname'];
        $user = self::$config['user'];
        $password = self::$config['password'];

        return new PDO($dsn, $user, $password);
    }
}