<?php
namespace App\Utilities;

use Firebase\JWT\JWT;

class TokenGenerator {
    private $secretKey = "1234Staffed";

    // Adjust the parameters to handle both employeeId and employerId correctly
    public function generateToken($userId, $username, $userType, $employerId = null, $employeeId = null) {
        $issuedAt = time(); 
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        
        $payload = [
            "iss" => "your_domain.com",
            "aud" => "your_domain.com",
            "iat" => $issuedAt,
            'exp' => $expirationTime,
            "data" => [
                "id" => $userId,
                "username" => $username,
                "user_type" => $userType,
                "employer_id" => $employerId,
                "employee_id" => $employeeId 
            ]
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
