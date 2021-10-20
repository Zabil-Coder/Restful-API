<?php
//functions, headers and includes
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: Put');
header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization');

include_once 'config/db.php';
include_once 'config/globals.php';
include_once 'models/user.php';

function updatePassword($data) {
    $db = new Database();
    $user = new User($db->get_connection());
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $data['newPassword'] = md5($data['newPassword']);
    return $user->updatePassword($data['email'], $data['newPassword']);
}
?>

<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $message = 'Password Updated Successfully';
    $error = false;
    $status = 200;
    $missingKeys = getMissingKeys($data, 'email', 'newPassword');
    if(count($missingKeys)) {
        $message = 'Please enter '.implode(',', $missingKeys);
        $error = true;
        $status = 400;
    } else {
        $mysqlError = updatePassword($data);
        if($mysqlError) {
            if ($mysqlError === '404') {
                $message =  'User not found';
                $status = 404;
            } else {
                $message = $mysqlError;
                $status = 503;
            }
            $error = true;  
        }
    }
    http_response_code($status);
    echo json_encode(['data' => $message, 'error' => $error]);
?>
