<?php
class Invoice {
    // Database connection and table name
    private $conn;
    private $table_name = "invoices";

    // Object properties
    public $id;
    public $employee_id;
    public $date;
    public $total_amount;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read invoices
    function read() {
        // Select all query
        $query = "SELECT id, employee_id, date, total_amount FROM " . $this->table_name;

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    
    // Create invoice
    function create() {
        // Query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET employee_id=:employee_id, date=:date, total_amount=:total_amount";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));

        // Bind values
        $stmt->bindParam(":employee_id", $this->employee_id);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":total_amount", $this->total_amount);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }


    // Update the invoice
    function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET employee_id = :employee_id, date = :date, total_amount = :total_amount WHERE id = :id";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind new values
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':total_amount', $this->total_amount);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }


    // Delete the invoice
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

    // Read single invoice
    function readSingle() {
        // Query to read single record
        $query = "SELECT id, employee_id, date, total_amount FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

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
            $this->employee_id = $row['employee_id'];
            $this->date = $row['date'];
            $this->total_amount = $row['total_amount'];
        } else {
            // If no record found, set properties to null
            $this->employee_id = null;
            $this->date = null;
            $this->total_amount = null;
        }
    }
}
?>
