<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Employee.php';

$database = new Database();
$db = $database->getConnection();

$employee = new Employee($db);

$stmt = $employee->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $employees_arr = array();
    $employees_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $employee_item = array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "phone" => $phone,
            "role" => $role,
            "username" => $username,
            "date_added" => $date_added
        );

        array_push($employees_arr["records"], $employee_item);
    }

    http_response_code(200);
    echo json_encode($employees_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No employees found."));
}
?>
