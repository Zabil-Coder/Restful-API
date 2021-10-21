<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: Post');
header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization');

include_once 'models/user.php';
?>

<?php
$data = json_decode(file_get_contents('php://input'), true);
$error = false;
$status = 200;
$result = 'Login Successfully';
$missingKeys = getMissingKeys($data, 'email', 'password');
if(count($missingKeys)){
    $result = 'Please enter valid '. implode(", ", $missingKeys);
    $status = 400;
    $error = true;
} else {
    $user = new User();
    if(!$user->validateLogin($data['email'], md5($data['password']))) {
        $error = true;
        $status = 404;
        $result = 'Invalid Email or Password' ;
    }
}
http_response_code($status);
echo json_encode(['data'=>$result, 'error' => $error]);
?>