<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Supplier.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare supplier object
$supplier = new Supplier($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID property of supplier to be edited
$supplier->id = $data->id;

// Set supplier property values
$supplier->name = $data->name;
$supplier->contact = $data->contact;
$supplier->address = $data->address;

// Update the supplier
if($supplier->update()) {
    // Set response code - 200 OK
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Supplier was updated."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to update supplier."));
}
?>
