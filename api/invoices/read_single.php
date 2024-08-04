<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Invoice.php';

// Get the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the Invoice object
$invoice = new Invoice($db);

// Get the ID of the invoice to be read
$invoice->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of the invoice
$invoice->readSingle();

if ($invoice->employee_id != null) {
    // Create array
    $invoice_arr = array(
        "id" => $invoice->id,
        "employee_id" => $invoice->employee_id,
        "date" => $invoice->date,
        "total_amount" => $invoice->total_amount
    );

    
    // Set response code - 200 OK
    http_response_code(200);

    // Output in JSON format
    echo json_encode($invoice_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Output error message
    echo json_encode(array("message" => "Invoice does not exist."));
}
?>