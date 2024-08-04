<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Inventory.php';

// Instantiate database and inventory object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$inventory = new Inventory($db);

// Query inventory
$stmt = $inventory->read();
$num = $stmt->rowCount();

// Check if more than 0 record found
if($num > 0) {
    // Inventory array
    $inventory_arr = array();
    $inventory_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $inventory_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "unit_price" => $unit_price,
            "quantity" => $quantity,
            "supplier_id" => $supplier_id,
            "date_added" => $date_added
        );

        array_push($inventory_arr["records"], $inventory_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show inventory data in json format
    echo json_encode($inventory_arr);
} else {
    // Set response code - 404 Not Found
    http_response_code(404);

    // Tell the user no inventory found
    echo json_encode(
        array("message" => "No inventory found.")
    );
}
?>
