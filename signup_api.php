<?php
    //headers and includes
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: Post');
    header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin');

    include_once 'models/user.php';
?>

<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $message = "Data entered successfully";
    $error = false;
    $status = 200;
    $missingKeys = getMissingKeys($data, 'name', 'email', 'password');
    if(count($missingKeys)) {
        $error = true;
        $message = "Please enter ".implode(', ', $missingKeys);
        $status = 400;
    
    } else {
        $user = new User();
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $mysqlError = $user->signUp($data['name'], $data['email'], md5($data['password'])); //email will be validated by getMissingKeys
        if($mysqlError){
            $message = $mysqlError;
            $error = true;
            $status = 503;
        }
    }
    http_response_code($status);
    echo json_encode(['data' => $message, 'error' => $error]);
?>