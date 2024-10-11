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
    public function handleLogin($email, $password) {
        $user = $this->userModel->checkUser($email, $password);
    
        if (is_array($user)) {
            error_log(print_r($user, true));
            $userType = $user['user_type']; 
            $employerId = $userType === 'employer' ? $user['employer_id'] : null;
            $employeeId = $userType === 'employee' ? (isset($user['employee_id']) ? $user['employee_id'] : null) : null;
    
            $jwtToken = $this->generateJWT($user['user_id'], $user['username'], $userType, $employerId, $employeeId);
            return ['status' => 'success', 'message' => 'Login successful.', 'token' => $jwtToken, 'user_details' => $user];
        } elseif ($user === "Wrong") {
            return ['status' => 'error', 'message' => 'Invalid password.'];
        } else {
            return ['status' => 'error', 'message' => 'Invalid username or password.'];
        }
    }
    
    


   private function generateJWT($userId, $username, $userType, $employerId = null, $employeeId = null)
{
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; 
    $payload = [
        "iss" => "your_domain.com",
        "iat" => $issuedAt,
        "exp" => $expirationTime,
        "data" => [
            "id" => $userId,
            "username" => $username,
            "user_type" => $userType,
            "employer_id" => $employerId,
            "employee_id" => $employeeId
        ]
    ];

    return JWT::encode($payload, "1234Staffed", 'HS256');
}
}
