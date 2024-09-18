<?php

require_once (__DIR__ . "/../Models/profile.php");


require_once (__DIR__ . "/../../composer/vendor/autoload.php");
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class userprofile {
    private $userModel;
    private $secret_key = "1234Staffed";

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }


    
    public function verifyJWT($jwt) {
        try {
            // Ensure $jwt is a string
            if (!is_string($jwt)) {
                throw new Exception("JWT token must be a string");
            }
            $key = new Key($this->secret_key, 'HS256'); // Use the Key class
            $decoded = JWT::decode($jwt, $key);
            return $decoded;
        } catch (Exception $e) {
            return null; // Handle errors
        }
    }




    public function getUserIdFromToken() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
    
        if (strpos($authHeader, 'Bearer ') === 0) {
            $jwt = explode(' ', $authHeader)[1];
    
            // Verify JWT
            if (empty($jwt)) {
                throw new Exception("JWT token is missing");
            }
    
            $userData = $this->verifyJWT($jwt);
    
            if ($userData && isset($userData->user_id)) {
                return $userData->user_id; 
            } else {
              
                echo json_encode(['status' => 'error', 'message' => 'user_id not found in token']);
                return null;
            }
        } else {
            // No token provided
            echo json_encode(['status' => 'error', 'message' => 'Authorization token not provided']);
            return null;
        }
    }
    
    


    public function storeImage($file) {
        $targetDir = "uploads/";
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);  // Create directory if it doesn't exist
        }
        $targetFile = $targetDir . time() . '_' . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        }
        return false;
    }
}
