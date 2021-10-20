<?php
include_once 'config/globals.php';

class User {
    private $table;
    private $conn;

    public function __construct(\Mysqli $conn)
    {
        $this->conn = $conn;
        $this->table = user_table;
    }

    public function validateLogin($email, $password)
    {
        $result = $this->conn->query("SELECT u.name FROM {$this->table} u WHERE u.email={$email} AND u.password={$password}");
        if($result->num_rows == 1) {
            return true;
        }
        return false;
    }

    public function signUp(string $name, string $email, string $password)
    {
        $this->conn->query("INSERT INTO {$this->table} (`name`, `email`, `password`) VALUES ('{$name}', '{$email}', '{$password}')");
        return $this->conn->error;
    }

    public function updatePassword(string $email, string $password) 
    {
        $this->conn->query("UPDATE {$this->table} SET `password`='{$password}' WHERE `email`='{$email}'");
        $error = '';
        if($this->conn->error) {
            $error = $this->conn->error;
        } else if (!mysqli_affected_rows($this->conn)){
            $error = '404';
        }
        return $error;
    }
}
?>