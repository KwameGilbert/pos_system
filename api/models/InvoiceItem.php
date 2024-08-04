<?php
class InvoiceItem {
    // Database connection and table name
    private $conn;
    private $table_name = "invoice_items";

    // Object properties
    public $id;
    public $invoice_id;
    public $product_id;
    public $quantity;
    public $unit_price;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read invoice items
    function read() {
        // Select all query
        $query = "SELECT id, invoice_id, product_id, quantity, unit_price FROM " . $this->table_name;

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create invoice item
    function create() {
        // Query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET invoice_id=:invoice_id, product_id=:product_id, quantity=:quantity, unit_price=:unit_price";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));

        // Bind values
        $stmt->bindParam(":invoice_id", $this->invoice_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":unit_price", $this->unit_price);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Update the invoice item
    function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET invoice_id = :invoice_id, product_id = :product_id, quantity = :quantity, unit_price = :unit_price WHERE id = :id";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind new values
        $stmt->bindParam(':invoice_id', $this->invoice_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':unit_price', $this->unit_price);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete the invoice item
    function delete() {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read single invoice item
    function readSingle() {
        // Query to read single record
        $query = "SELECT id, invoice_id, product_id, quantity, unit_price FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if more than 0 record found
        if($row) {
            // Set values to object properties
            $this->invoice_id = $row['invoice_id'];
            $this->product_id = $row['product_id'];
            $this->quantity = $row['quantity'];
            $this->unit_price = $row['unit_price'];
        } else {
            // If no record found, set properties to null
            $this->invoice_id = null;
            $this->product_id = null;
            $this->quantity = null;
            $this->unit_price = null;
        }
    }
}
?>
