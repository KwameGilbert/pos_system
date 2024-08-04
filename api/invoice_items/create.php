<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/InvoiceItem.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare invoice item object
$invoice_item = new InvoiceItem($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Set invoice item property values
$invoice_item->invoice_id = $data->invoice_id;
$invoice_item->product_id = $data->product_id;
$invoice_item->quantity = $data->quantity;
$invoice_item->unit_price = $data->unit_price;

// Create the invoice item
if($invoice_item->create()) {
    // Set response code - 201 Created
    http_response_code(201);

    // Tell the user
    echo json_encode(array("message" => "Invoice item was created."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to create invoice item."));
}
?>
