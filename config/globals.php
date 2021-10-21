<?php
    define('host', 'localhost');
    define('db', 'employees_db');
    define('username', 'root');
    define('password', 'root');
    define('user_table', 'users');
    define('employee_table', 'employees');

    function getMissingKeys($data, ...$keys) {
        $missingKeys = [];
        foreach ($keys as $key){
            if (empty($data[$key]) or 
                ($key === 'email' and !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) or
                ($key === 'contact' and (!is_numeric($data['contact']) or strlen($data['contact']) != 11))) {
                $missingKeys[] = $key;
            }
        }
       return $missingKeys;
    }
?>