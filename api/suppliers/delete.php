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

// Set supplier id to be deleted
$supplier->id = isset($_GET['id']) ? $_GET['id'] : die();

// Delete the supplier
if($supplier->delete()) {
    // Set response code - 200 OK
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Supplier was deleted."));
} else {
    // Set response code - 503 Service Unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to delete supplier."));
}
?>