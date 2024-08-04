<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Invoice.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare invoice object
$invoice = new Invoice($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Set invoice property values
$invoice->employee_id = $data->employee_id;
$invoice->date = date('Y-m-d H:i:s');
$invoice->total_amount = $data->total_amount;

// Create the invoice
if($invoice->create()) {
    // Set response code - 201 Created
    http_response_code(201);

    // Tell the user
    echo json_encode(array("message" => "Invoice was created."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to create invoice."));
}
?>
