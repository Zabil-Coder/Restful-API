<?php
include_once 'config/globals.php';
class Database {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(host, username, password, db);
        if($this->conn->connect_errno) {
            echo "Failed to connect to MySQL Database: " . $this->conn->connect_error;
        }
    }

    public function get_connection()
    {
        return $this->conn;
    }
}
?>