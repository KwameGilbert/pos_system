<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Employee.php';

$database = new Database();
$db = $database->getConnection();

$employee = new Employee($db);

$employee->id = isset($_GET['id']) ? $_GET['id'] : die();

    if ($employee->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Employee was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete employee."));
    }

?>