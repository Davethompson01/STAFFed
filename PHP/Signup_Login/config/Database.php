<?php
class Database {

    private $DB_HOST = "localhost";
    private $DB_NAME = "challange";
    private $DB_USER = "challange";
    private $DB_PASS = 'Ayobami123.';

    private $connection;

    function __construct() {

    }

    public function getConnection() {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME, $this->DB_USER, $this->DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "connection succesful";
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }
}
