<?php
class Employee {
    private $conn;
    private $table_name = "employees";

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $role;
    public $username;
    public $password;
    public $date_added;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readSingle() {
    // Query to read single record
    $query = "SELECT
                id, firstname, lastname, email, phone, role, username, date_added
              FROM
                " . $this->table_name . "
              WHERE
                id = ?
              LIMIT
                0,1";

    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // Bind ID of employee to be read
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if more than 0 record found
    if ($row) {
        // Set values to object properties
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->role = $row['role'];
        $this->username = $row['username'];
        $this->date_added = $row['date_added'];
    } else {
        // If no record found, set properties to null
        $this->firstname = null;
        $this->lastname = null;
        $this->email = null;
        $this->phone = null;
        $this->role = null;
        $this->username = null;
        $this->date_added = null;
    }
}


    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET
                    firstname=:firstname, lastname=:lastname, email=:email, phone=:phone, role=:role, username=:username, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));

        //Hash PASSWORD_BCRYPT
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password );

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET
                    firstname=:firstname, lastname=:lastname, email=:email, phone=:phone, role=:role, username=:username
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
