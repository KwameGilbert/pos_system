<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/Database.php';
include_once 'models/Employee.php';
include_once 'models/Inventory.php';
include_once 'models/Invoice.php';
include_once 'models/InvoiceItem.php';
include_once 'models/Supplier.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get the request method
$request_method = $_SERVER['REQUEST_METHOD'];

// Parse the request URI
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$endpoint = isset($request_uri[0]) ? $request_uri[0] : '';
$id = isset($request_uri[1]) ? $request_uri[1] : null;

// Route the request
switch ($endpoint) {
    case 'employees':
    case 'inventory':
    case 'invoices':
    case 'invoice_items':
    case 'suppliers':
        // Include the resource-specific index.php
        $_GET['id'] = $id; // Pass the ID to the resource-specific script
        include $endpoint.'/index.php';
        break;
    default:
        // Set response code - 404 Not Found
        http_response_code(404);
        echo json_encode(array("message" => "Endpoint not found."));
        break;
}
?>
