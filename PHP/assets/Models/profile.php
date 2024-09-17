<?php

require_once (__DIR__ . "/../../config/Database.php");
// UserModel.php
class UserModel {
    private $conn;

    public function __construct($database) {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function updateUserProfile($userId, $imagePath) {
        $query = "UPDATE staffed_users SET user_profile = :user_profile WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_profile', $imagePath);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
}


