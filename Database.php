<?php
namespace App;

class Database {

    private static $db;
    private $connection;

    private function __construct() {
    	$host     = 'localhost';
		$db       = 'demoapp';
		$user     = 'demoapp';
		$password = '123456';
		$port     = 3306;
		$charset  = 'utf8mb4';

        $this->connection = new \mysqli($host, $user, $password, $db, $port);
        $this->connection->set_charset($charset);
		$this->connection->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    }

    function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
}