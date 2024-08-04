<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Invoice.php';

// Instantiate database and invoice object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$invoice = new Invoice($db);

// Query invoices
$stmt = $invoice->read();
$num = $stmt->rowCount();

// Check if more than 0 record found
if($num > 0) {
    // Invoices array
    $invoices_arr = array();
    $invoices_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $invoice_item = array(
            "id" => $id,
            "employee_id" => $employee_id,
            "date" => $date,
            "total_amount" => $total_amount
        );

        array_push($invoices_arr["records"], $invoice_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show invoices data in json format
    echo json_encode($invoices_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Tell the user no invoices found
    echo json_encode(
        array("message" => "No invoices found.")
    );
}
?>
