<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Supplier.php';

// Instantiate database and supplier object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$supplier = new Supplier($db);

// Query suppliers
$stmt = $supplier->read();
$num = $stmt->rowCount();

// Check if more than 0 record found
if($num > 0) {
    // Suppliers array
    $suppliers_arr = array();
    $suppliers_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $supplier_item = array(
            "id" => $id,
            "name" => $name,
            "contact" => $contact,
            "address" => $address,
            "date_added" => $date_added
        );

        array_push($suppliers_arr["records"], $supplier_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show suppliers data in json format
    echo json_encode($suppliers_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Tell the user no suppliers found
    echo json_encode(array("message" => "No suppliers found."));
}
?>
