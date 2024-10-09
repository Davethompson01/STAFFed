<?php

namespace App\Utilities;

use Firebase\JWT\JWT;

class TokenGenerator {
    private $secretKey = "1234Staffed";

    public function generateToken($userId, $username, $userType) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        $payload = [
            "iss" => "your_domain.com",
            "aud" => "your_domain.com",
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => [
                "id" => $userId,
                "username" => $username,
                "user_type" => $userType // Include user_type in the token payload
            ]
        ];
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
