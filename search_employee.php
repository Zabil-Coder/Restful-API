<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: Get');
header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin');

include_once 'models/employee.php';
?>

<?php
$data = json_decode(file_get_contents('php://input'), true);
$error = false;
$status = 200;
$result = '';
if(count(getMissingKeys($data, 'email'))){
    $result = 'Please enter valid email';
    $status = 400;
    $error = true;
} else {
    $employee = new Employee();
    $result = $employee->getEmployees($data['email']);
    if(!$result) {
        $error = true;
        $status = 404;
        $result = 'No Record Found' ;
    }
}
http_response_code($status);
echo json_encode(['data'=>$result, 'error' => $error]);
?>