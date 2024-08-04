<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Employee.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get the request method
$request_method = $_SERVER['REQUEST_METHOD'];

// Get the ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Route based on request method
switch ($request_method) {
    case 'GET':
        if ($id) {
            include 'read_single.php';
        } else {
            include 'read.php';
        }
        break;
    case 'POST':
        include 'create.php';
        break;
    case 'PUT':
        include 'update.php';
        break;
    case 'DELETE':
        include 'delete.php';
        break;
    default:
        // Set response code - 405 Method Not Allowed
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
