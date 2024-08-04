<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Inventory.php';

// Get the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the Inventory object
$inventory = new Inventory($db);

// Get the ID of the inventory item to be read
$inventory->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of the inventory item
$inventory->readSingle();

if ($inventory->name != null) {
    // Create array
    $inventory_arr = array(
        "id" => $inventory->id,
        "name" => $inventory->name,
        "description" => $inventory->description,
        "unit_price" => $inventory->unit_price,
        "quantity" => $inventory->quantity,
        "supplier_id" => $inventory->supplier_id,
        "date_added" => $inventory->date_added
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Output in JSON format
    echo json_encode($inventory_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Output error message
    echo json_encode(array("message" => "Inventory item does not exist."));
}
?>
