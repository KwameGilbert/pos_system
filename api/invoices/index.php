<?php
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
