<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/InvoiceItem.php';

// Get the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the InvoiceItem object
$invoice_item = new InvoiceItem($db);

// Get the ID of the invoice item to be read
$invoice_item->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of the invoice item
$invoice_item->readSingle();

if ($invoice_item->product_id != null) {
    // Create array
    $invoice_item_arr = array(
        "id" => $invoice_item->id,
        "invoice_id" => $invoice_item->invoice_id,
        "product_id" => $invoice_item->product_id,
        "quantity" => $invoice_item->quantity,
        "unit_price" => $invoice_item->unit_price
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Output in JSON format
    echo json_encode($invoice_item_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Output error message
    echo json_encode(array("message" => "Invoice item does not exist."));
}
?>
