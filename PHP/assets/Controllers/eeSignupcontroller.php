<?php

namespace App\Controllers;
require_once(__DIR__ . "/../../vendor/autoload.php");
require_once(__DIR__ . '/../Models/eeUsersignup.php');
require_once(__DIR__ . "/../Utilities/TokenGenerator.php");
require_once(__DIR__ . "/../Requests/SignupRequest.php");
use App\Config\Database;
use App\Models\User;
use App\Utilities\TokenGenerator;
use App\Requests\SignupRequest;

class SignupController {
    private $userModel;
    private $tokenGenerator;

    public function __construct() {
        $this->userModel = new User(new Database());
        $this->tokenGenerator = new TokenGenerator();
    }

    public function handleSignup() {
        header('Content-Type: application/json');
        $signupRequest = new SignupRequest();
        function getIpAddress() {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                
                return $_SERVER['HTTP_CLIENT_IP'];
    
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
              
                return trim($ips[0]); 
            } else {
             
                return $_SERVER['REMOTE_ADDR'];
            }
        }
        
        $data = $signupRequest->validateSignupData();
        $data['ip_address'] = getIpAddress();
        

        if (!$data) {
            return; 
        }

        if ($this->userModel->checkEmail($data['email'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Email already taken.']);
            return;
        }

        $userId = $this->userModel->createUser($data );
        // $token = $this->tokenGenerator->generateToken($userId, $data['username'], 'employer');
        if ($userId) {
            $token = $this->tokenGenerator->generateToken($userId, $data['username'], 'employer');
    
            // Now, update the user record with the token
            $this->userModel->updateToken($userId, $token);
    
            $this->sendResponse([
                'status' => 'success',
                'message' => 'Signup successful',
                'id' => $userId,
                'username' => $data['username'],
                'email' => $data['email'],
                'number' => $data['number'],
                'country' => $data['country'],
                'userType' => 'employee',
                'token' => $token,
            ]);
        } else {
            $this->sendResponse(['status' => 'error', 'message' => 'Signup failed. Please try again.']);
        }
    }


    private function updateUserToken($userId, $token) {
        // Assuming you add a method in the User model to update the token
        $this->userModel->updateToken($userId, $token);
    }

    private function sendResponse(array $response) {
        echo json_encode($response);
        exit;
    }
}