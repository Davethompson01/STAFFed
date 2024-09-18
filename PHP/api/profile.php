<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require_once (__DIR__ . "/../assets/Controllers/profile.php");
require_once (__DIR__ . "/../assets/Models/profile.php");

use \Firebase\JWT\JWT;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Database();
        $userModel = new UserModel($database);
        $jwt = new userprofile($userModel);
       

        if ($jwt) {

            $profilePicture = $_FILES['user_profile'] ?? null;
            // Validate that username is set
            $userId = $jwt->verifyJWT($jwt);
            if (!$userId) {
                echo json_encode(['status'=>'error','message'=>"Invalid token or user not logged in!"]);
                exit;
            }
            $username = $_POST['username'] ?? null;
            if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                // Store image and get the path
                $imagePath = $jwt->storeImage($profilePicture);

                if ($imagePath && $userId) {
                    // Call model to update the user's profile picture
                    $userModel->updateUserProfile($userId, $imagePath);
                    echo json_encode(["status" => "success","message"=>"Profile picture updated successfully!"]);
                } else {
                    echo json_encode(["status"=>"error",'message'=>'Failed to upload image or user ID missing!']);
                }
            } else {
                echo json_encode(['status'=>'error',"message"=>"No file uploaded or upload error!"]);
            }
        } else {
            echo json_encode(['status'=>'error','message'=>"Invalid token or user not logged in!"]);
        }
    }