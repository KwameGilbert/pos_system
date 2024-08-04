<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Employee.php';

// Get the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the Employee object
$employee = new Employee($db);

// Get the ID of the employee to be read
$employee->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of the employee
$employee->readSingle();

if ($employee->firstname != null) {
    // Create array
    $employee_arr = array(
        "id" => $employee->id,
        "firstname" => $employee->firstname,
        "lastname" => $employee->lastname,
        "email" => $employee->email,
        "phone" => $employee->phone,
        "role" => $employee->role,
        "username" => $employee->username,
        "date_added" => $employee->date_added
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Output in JSON format
    echo json_encode($employee_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Output error message
    echo json_encode(array("message" => "Employee does not exist."));
}
?>
