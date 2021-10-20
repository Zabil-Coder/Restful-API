<?php
    //functions, headers and includes
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: Post');
    header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization');

    include_once 'config/db.php';
    include_once 'config/globals.php';
    include_once 'models/user.php';

    function signUp($data) {
        $db = new Database();
        $user = new User($db->get_connection());
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $data['password'] = md5($data['password']);
        return $user->signUp($data['name'], $data['email'], $data['password']);
    }
?>

<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $message = "Data entered successfully";
    $error = false;
    $status = 200;
    $missingKeys = getMissingKeys($data, 'name', 'email', 'password');
    if(count($missingKeys)) {
        $error = true;
        $message = "Please enter ".implode(',', $missingKeys);
        $status = 400;
    
    } else {
        $mysqlError = signUp($data);
        if($mysqlError){
            $message = $mysqlError;
            $error = true;
            $status = 503;
        }
    }
    http_response_code($status);
    echo json_encode(['data' => $message, 'error' => $error]);
?>