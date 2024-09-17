<?php

require_once (__DIR__ . "/../Models/profile.php");
use \Firebase\JWT\JWT;
class UserController {
    private $userModel;
    private $secret_key = "1234Staffed";

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }


    
    function verifyJWT($jwt) {
        try {
            $key = new Firebase\JWT\Key($this->secret_key, 'HS256');
            $decoded = JWT::decode($jwt, $key, ['HS256']);
            return $decoded;
        } catch (Exception $e) {
            return null; // Handle errors
        }
    }
    public function uploadImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the logged-in user's ID from the JWT token
            $jwt = $this->getUserIdFromToken();

            if ($jwt) {
                // Validate that username is set
                $userId = $this->verifyJWT($jwt);
                $username = $_POST['username'] ?? null;
                $profilePicture = $_FILES['user_profile'] ?? null;

                // Check if the file is uploaded
                if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                    // Store image and get the path
                    $imagePath = $this->storeImage($profilePicture);

                    if ($imagePath && $userId) {
                        // Call model to update the user's profile picture
                        $this->userModel->updateUserProfile($userId, $imagePath);
                        echo "Profile picture updated successfully!";
                    } else {
                        echo "Failed to upload image or user ID missing!";
                    }
                } else {
                    echo "No file uploaded or upload error!";
                }
            } else {
                echo "Invalid token or user not logged in!";
            }
        }
    }



    private function getUserIdFromToken() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
    
        if (strpos($authHeader, 'Bearer ') === 0) {
            $jwt = explode(' ', $authHeader)[1];
    
            // Verify JWT
            $userData = $this->verifyJWT($jwt);
    
            if ($userData) {
                // Access granted, process request
                return $userData->user_id; // Assuming 'user_id' is the claim in your JWT
            } else {
                // Invalid token
                echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
                return null;
            }
        } else {
            // No token provided
            echo json_encode(['status' => 'error', 'message' => 'Authorization token not provided']);
            return null;
        }
    }


    private function storeImage($file) {
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
