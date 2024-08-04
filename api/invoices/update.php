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

// Set ID property of invoice to be edited
$invoice->id = $data->id;

// Set invoice property values
$invoice->employee_id = $data->employee_id;
$invoice->date = $data->date;
$invoice->total_amount = $data->total_amount;

// Update the invoice
if($invoice->update()) {
    // Set response code - 200 OK
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Invoice was updated."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to update invoice."));
}
?>
