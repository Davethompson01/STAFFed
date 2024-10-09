<?php

namespace App\Models;

require_once(__DIR__ . "/../../config/Database.php");
use App\Config\Database;
use App\Models\Exception;

use PDO;

class User {

    private $connection;

    public function __construct(Database $database) {
        $this->connection = $database->getConnection(); // Use the connection from the passed database object
    }

    public function checkEmail($email) {
        $query = "SELECT user_email FROM staffed_users WHERE user_email = :user_email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function createUser($data) {
        $query = "INSERT INTO staffed_users (username, user_email, user_password, user_country, user_phoneNumber, ip_address, user_type) 
              VALUES (:username, :user_email, :user_password, :user_country, :user_number, :ip_address, :user_type)";
        $stmt = $this->connection->prepare($query);
    
        $userType = 'employee';
        if (isset($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_ARGON2ID);
        } else {
            throw new Exception('Password is required');
        }
    
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':user_email', $data['email']);
        $stmt->bindParam(':user_password', $hashedPassword);
        $stmt->bindParam(':user_country', $data['country']);
        $stmt->bindParam(':user_number', $data['number']);
        $stmt->bindParam(':ip_address', $data['ip_address']);
        $stmt->bindParam(':user_type', $userType);
    
        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }

    public function updateToken($userId, $token) {
        $query = "UPDATE staffed_users SET user_token = :user_token WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_token', $token);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
    
}
