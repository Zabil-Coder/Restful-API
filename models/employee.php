<?php
include_once 'config/db.php';
include_once 'config/globals.php';

class Employee extends Database {
    private $table;
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = $this->get_connection();
        $this->table = employee_table;
    }

    public function getEmployees(string $email=null)
    {
        $query = "SELECT * FROM {$this->table} e";
        if($email) {
            $query .= " WHERE e.email='{$email}'";
        }
        $result = $this->conn->query($query);
        if ($result->num_rows) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $result = null;
        }
        return $result;
    }

    public function addEmployee(string $name, string $email, string $contact, string $salary, string $role, string $office)
    {
        $query = "INSERT INTO {$this->table} (`name`, `email`, `contact`, `salary`, `role`, `office`) VALUES 
        ('{$name}', '{$email}', '{$contact}', '{$salary}', '{$role}', '{$office}')";
        $this->conn->query($query);
        return $this->conn->error;
    }
}

?>