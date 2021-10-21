<?php
    //functions, headers and includes
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: Post');
    header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin');

    include_once 'models/employee.php';

    function addEmployee($data) {
        $employee = new Employee();
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        return $employee->addEmployee($data['name'], $data['email'], $data['contact'], $data['salary'], $data['role'], $data['office']);
    }
?>

<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $message = "Data entered successfully";
    $error = false;
    $status = 200;
    $missingKeys = getMissingKeys($data, 'name', 'email', 'contact',  'salary', 'role', 'office');
    if(count($missingKeys)) {
        $error = true;
        $message = "Please enter valid ".implode(", ", $missingKeys);
        $status = 400;
    
    } else {
        $mysqlError = addEmployee($data);
        if($mysqlError){
            $message = $mysqlError;
            $error = true;
            $status = 503;
        }
    }
    http_response_code($status);
    echo json_encode(['data' => $message, 'error' => $error]);
?>