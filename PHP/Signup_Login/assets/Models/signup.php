<?php
include_once(__DIR__ . '/../../Config/Database.php');

// Define the SignupModel that instantiate the Database class
class SignupModel{

    private $username;
    private $password;
    private $connection;

    public function __construct(    ) {
        $database = new Database();
        $this->connection = $database->getConnection();    
    }

    public function setData($username,$password) {
        $this->username = $username['username'];
        $this->password = $password['password'];
        
    }

    public function checkUsername() {
        $query = "SELECT user_name FROM users WHERE user_name = :username;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false; // Return true if username exists, false otherwise
    }

    public function setUser() {
        $query = "INSERT INTO users (user_name, user_password) VALUES (:username, :password);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashedPassword);
        
        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        } else {
            return false; 
        }
    }
    
}
