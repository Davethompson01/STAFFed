<?php

namespace App\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;

class LoginController {
        private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
   public function handleLogin($email, $password)
{
    session_start();
    $user = $this->userModel->checkUser($email, $password);

    if (is_array($user)) {
        $jwtToken = $this->generateJWT(
            $user['user_id'], 
            $user['username'], 
            $user['user_type'], 
            $user['employer_id'] ?? null // Include employer_id if available
        );
        


        $_SESSION['user_id'] = $user['user_id']; // Store user ID
        $_SESSION['user_type'] = $user['user_type'];
        return ['status' => 'success', 'message' => 'Login successful.', 'token' => $jwtToken, 'user_details' => $user];
    } elseif ($user === "Wrong") {
        return ['status' => 'error', 'message' => 'Invalid password.'];
    } else {
        return ['status' => 'error', 'message' => 'Invalid username or password.'];
    }
}


    private function generateJWT($userId, $username, $userType, $employerId = null)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // JWT valid for 1 hour
        $payload = [
            "iss" => "your_domain.com",
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => [
                "id" => $userId,
                "username" => $username,
                "user_type" => $userType,
                "employer_id" => $employerId 
            ]
        ];
    
        $jwt = JWT::encode($payload, "1234Staffed", 'HS256');
        return $jwt;
    }
    
}
