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
            if (empty($data[$key]) or ($key === 'email' and !filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
                $missingKeys[] = $key;
            }
        }
       return $missingKeys;
    }
?>