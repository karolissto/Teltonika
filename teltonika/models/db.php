<?php
class db
{
    private static $connection;

    // Connection settings
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,

    );

    // Connects to the database with given variables
    public static function connect($host, $user, $password, $database)
    {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings
            );
        }
    }

    // Prepares and executes database query
    public static function queryDB($query)
    {
        $result = self::$connection->prepare($query);       // Prepares query
        $result->execute();                                 // Executes it

        $result->setFetchMode(PDO::FETCH_ASSOC);            // Sets fetch mode
        return $result;                                     // Returns result
    }

}


?>