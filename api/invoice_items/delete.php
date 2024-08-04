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



// Set invoice item id to be deleted
$invoice_item->id = isset($_GET['id']) ? $_GET['id'] : die();

// Delete the invoice item
if($invoice_item->delete()) {
    // Set response code - 200 OK
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Invoice item was deleted."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to delete invoice item."));
}
?>
