<?php
// Parse the request URI
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$endpoint = isset($request_uri[0]) ? $request_uri[0] : '';
$id = isset($request_uri[1]) ? $request_uri[1] : null;

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (isset($id)) {
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
        if ($id) {
            include 'delete.php';
        } 
        break;
    default:
        // Set response code - 405 Method Not Allowed
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
