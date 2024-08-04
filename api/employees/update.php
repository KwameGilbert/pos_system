<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Employee.php';

$database = new Database();
$db = $database->getConnection();

$employee = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    !empty($data->role) &&
    !empty($data->username)
) {
    $employee->id = $data->id;
    $employee->firstname = $data->firstname;
    $employee->lastname = $data->lastname;
    $employee->email = $data->email;
    $employee->phone = $data->phone;
    $employee->role = $data->role;
    $employee->username = $data->username;

    if ($employee->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Employee was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update employee."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update employee. Data is incomplete."));
}
?>
