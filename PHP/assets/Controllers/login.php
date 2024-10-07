<?php
include_once (__DIR__ . '/../Models/Model.php');
use Firebase\JWT\JWT;

// use \Firebase\JWT\JWT;

class LoginAuth {

    private $userLogin;
    private $loginModel;
    private $secret_key = "1234Staffed"; // Secret key for JWT signing

    public function __construct() {
        $this->userLogin = new UserLogin();
        $this->loginModel = new LoginModel();
    }

    public function handleLogin($email, $password): array {
        $cleanedData = ['email' => $email, 'password' => $password]; // Directly pass the data

        $this->loginModel->setData($cleanedData);
        $user = $this->loginModel->checkUser();

        if (is_array($user)) {
            // Generate a JWT token if login is successful
            $jwtToken = $this->generateJWT($user['user_id'], $user['username']);
            return ['status' => 'success', 'message' => 'Login successful.', 'token' => $jwtToken, 'user_details' => $user];
        } elseif ($user === "Wrong") {
            return ['status' => 'error', 'message' => 'Invalid password.'];
        } else {
            return ['status' => 'error', 'message' => 'Invalid username or password.'];
        }
    }
    private function sendResponse($response) {
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Generate JWT token
    private function generateJWT($userId, $username) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // JWT valid for 1 hour
        $payload = array(
            "iss" => "your_domain.com",
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => array(
                "id" => $userId,
                "username" => $username
            )
        );
        

        // Encode the array to a JWT string
        $jwt = JWT::encode($payload, $this->secret_key, 'HS256');

        return $jwt;
    }

    public function getSecretKey(): string {
        return $this->secret_key;
    }
}


class UserLogin {

    private $data;

    public function __construct() {
        $this->getData();
    }

    public function getData() {
        $input = file_get_contents('php://input');
        $this->data = json_decode($input, true);
    }

    public function checkData() {
        if (empty($this->data)) {
            $this->sendResponse(['status' => 'error', 'message' => 'Invalid input. Provide your details.']);
            return false;
        }
        if (empty($this->data['email'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Invalid input.  is required.']);
            return false;
        }
        if (empty($this->data['password'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Invalid input. Password is required.']);
            return false;
        }
        return true;
    }

    private function setData() {
        if ($this->checkData()) {
            return $this->data;
        }
        return null;
    }

    public function cleanData() {
        if ($this->setData()) {
            $email = trim($this->data['email']);
            $password = trim($this->data['password']);
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    
            if (empty($email)) {
                $this->sendResponse(['status' => 'error', 'message' => 'Email is required.']);
                return null;
            }

            if (empty($email) || empty($password)) {
                $this->sendResponse(['status' => 'error', 'message' => 'Email and password are required']);
                return null;
            }
    
            if (empty($password)) {
                $this->sendResponse(['status' => 'error', 'message' => 'Password is required.']);
                return null;
            }
    
            return ['email' => $email, 'password' => $password];
        }
        return null;
    }
    

    private function sendResponse($response) {
        header('Content-Type: application/json');
        echo json_encode($response);
    }

   
}


