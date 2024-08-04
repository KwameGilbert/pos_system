<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Supplier.php';

// Get the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the Supplier object
$supplier = new Supplier($db);

// Get the ID of the supplier to be read
$supplier->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of the supplier
$supplier->readSingle();

if ($supplier->name != null) {
    // Create array
    $supplier_arr = array(
        "id" => $supplier->id,
        "name" => $supplier->name,
        "contact" => $supplier->contact,
        "address" => $supplier->address,
        "date_added" => $supplier->date_added
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Output in JSON format
    echo json_encode($supplier_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Output error message
    echo json_encode(array("message" => "Supplier does not exist."));
}
?>
