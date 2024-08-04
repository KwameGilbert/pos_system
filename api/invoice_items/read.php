<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/InvoiceItem.php';

// Instantiate database and invoice item object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$invoice_item = new InvoiceItem($db);

// Query invoice items
$stmt = $invoice_item->read();
$num = $stmt->rowCount();

// Check if more than 0 record found
if($num > 0) {
    // Invoice items array
    $invoice_items_arr = array();
    $invoice_items_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $invoice_item = array(
            "id" => $id,
            "invoice_id" => $invoice_id,
            "product_id" => $product_id,
            "quantity" => $quantity,
            "unit_price" => $unit_price
        );

        array_push($invoice_items_arr["records"], $invoice_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show invoice items data in json format
    echo json_encode($invoice_items_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Tell the user no invoice items found
    echo json_encode(
        array("message" => "No invoice items found.")
    );
}
?>
