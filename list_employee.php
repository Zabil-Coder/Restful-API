<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: Get');
header('Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin');

include_once 'models/employee.php';
include_once 'config/globals.php';
?>

<?php
$employee = new Employee();
$result = $employee->getEmployees();
$error = false;
$status = 200;
if(!$result) {
    $error = true;
    $status = 404;
    $result = 'No Record Found' ;
}
http_response_code($status);
echo json_encode(['data'=>$result, 'error' => $error]);
?>