<?php
class Supplier {
    // Database connection and table name
    private $conn;
    private $table_name = "suppliers";

    // Object properties
    public $id;
    public $name;
    public $contact;
    public $address;
    public $date_added;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read suppliers
    function read() {
        // Select all query
        $query = "SELECT id, name, contact, address, date_added FROM " . $this->table_name;

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create supplier
    function create() {
        // Query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, contact=:contact, address=:address, date_added=:date_added";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->date_added = htmlspecialchars(strip_tags($this->date_added));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":contact", $this->contact);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":date_added", $this->date_added);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Update the supplier
    function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET name = :name, contact = :contact, address = :address WHERE id = :id";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':contact', $this->contact);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete the supplier
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

    // Read single supplier
    function readSingle() {
        // Query to read single record
        $query = "SELECT id, name, contact, address, date_added FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

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
            $this->contact = $row['contact'];
            $this->address = $row['address'];
            $this->date_added = $row['date_added'];
        } else {
            // If no record found, set properties to null
            $this->name = null;
            $this->contact = null;
            $this->address = null;
            $this->date_added = null;
        }
    }
}
?>
