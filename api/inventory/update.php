<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Inventory.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare inventory object
$inventory = new Inventory($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID property of inventory to be edited
$inventory->id = $data->id;

// Set inventory property values
$inventory->name = $data->name;
$inventory->description = $data->description;
$inventory->unit_price = $data->unit_price;
$inventory->quantity = $data->quantity;
$inventory->supplier_id = $data->supplier_id;

// Update the inventory item
if($inventory->update()) {
    // Set response code - 200 OK
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Inventory item was updated."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to update inventory item."));
}
?>
