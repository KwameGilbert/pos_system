<?php
class Inventory {
    // Database connection and table name
    private $conn;
    private $table_name = "inventory";

    // Object properties
    public $id;
    public $name;
    public $description;
    public $unit_price;
    public $quantity;
    public $supplier_id;
    public $date_added;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read inventory
    function read() {
        // Select all query
        $query = "SELECT id, name, description, unit_price, quantity, supplier_id, date_added FROM " . $this->table_name;

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create inventory item
    function create() {
        // Query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:description, unit_price=:unit_price, quantity=:quantity, supplier_id=:supplier_id, date_added=:date_added";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->supplier_id = htmlspecialchars(strip_tags($this->supplier_id));
        $this->date_added = htmlspecialchars(strip_tags($this->date_added));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":unit_price", $this->unit_price);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":supplier_id", $this->supplier_id);
        $stmt->bindParam(":date_added", $this->date_added);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }


    // Update the inventory item
    function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, unit_price = :unit_price, quantity = :quantity, supplier_id = :supplier_id WHERE id = :id";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->supplier_id = htmlspecialchars(strip_tags($this->supplier_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':unit_price', $this->unit_price);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':supplier_id', $this->supplier_id);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    
    // Delete the inventory item
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

    // Read single inventory item
    function readSingle() {
        // Query to read single record
        $query = "SELECT id, name, description, unit_price, quantity, supplier_id, date_added FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

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
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->unit_price = $row['unit_price'];
            $this->quantity = $row['quantity'];
            $this->supplier_id = $row['supplier_id'];
            $this->date_added = $row['date_added'];
        } else {
            // If no record found, set properties to null
            $this->name = null;
            $this->description = null;
            $this->unit_price = null;
            $this->quantity = null;
            $this->supplier_id = null;
            $this->date_added = null;
        }
    }
}
?>
