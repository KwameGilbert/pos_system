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

// Set supplier property values
$supplier->name = $data->name;
$supplier->contact = $data->contact;
$supplier->address = $data->address;
$supplier->date_added = date('Y-m-d H:i:s');

// Check if the supplier already exists
$query = "SELECT id FROM suppliers WHERE name = ? LIMIT 0,1";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $supplier->name);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0) {
    // Set response code - 409 Conflict
    http_response_code(409);

    // Tell the user
    echo json_encode(array("message" => "Supplier already exists."));
} else {
    // Create the supplier
    if($supplier->create()) {
        // Set response code - 201 Created
        http_response_code(201);

        // Tell the user
        echo json_encode(array("message" => "Supplier was created."));
    } else {
        // Set response code - 503 Service Unavailable
        http_response_code(503);

        // Tell the user
        echo json_encode(array("message" => "Unable to create supplier."));
    }
}
?>
