

<?php

require_once (__DIR__ .  "/../../vendor/autoload.php");
use Firebase\JWT\JWT;

include_once(__DIR__ . '/../../Config/Database.php');
class SignupController  {

    private $username;
    private $email;
    private $number;
    private $country;
    private $password;
    private $connection;
    private $ipAddress;
    private $userType;
    private $secret_key = "1234Staffed";

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }


    public function generateToken() {
        return bin2hex(random_bytes(32)); // Generates a secure 64-character token
    }

    
    public function setData($username, $email, $number, $country, $password, $ipAddress,$userType) {
        $this->username = htmlspecialchars(trim($username), ENT_QUOTES, 'UTF-8');
        $this->email = htmlspecialchars(trim($email), ENT_QUOTES, 'UTF-8');
        $this->number = trim($number);
        $this->country = trim($country);
        $this->password = password_hash($password, PASSWORD_ARGON2ID); // Hash happens here
        $this->ipAddress = trim($ipAddress);
        $this->userType = trim($userType);
    }
    
    

    public function checkEmail() {
        $query = "SELECT user_email FROM staffed_users WHERE  user_email = :user_email;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_email', $this->email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    
    private function generateJWT($userId, $username) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        $payload = array(
            "iss" => "your_domain.com",   
            "aud" => "your_domain.com",    
            "iat" => $issuedAt,            
            "exp" => $expirationTime,   
            "data" => array(
                "id" => $userId,
                "username" => $username
            )
        );
        $jwt = JWT::encode($payload, $this->secret_key, 'HS256'); // Use HS256 instead of '1234Staffed'
    return $jwt;

        if (!class_exists('Firebase\JWT\JWT')) {
            throw new Exception('Firebase\JWT\JWT class not found');
        }
    }


    public function setUser($username, $email, $number, $country, $password, $ipAddress,$userType) {
        $userToken = $this->generateToken();
        $query = "INSERT INTO staffed_users (username, user_email, user_password, user_country, user_phoneNumber,ip_address,user_token,user_type) VALUES (:username, :email, :password, :country, :number,:ip_address, :user_token,:user_type);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':ip_address', $ipAddress);
        $stmt->bindParam(':user_token', $userToken);
        $stmt->bindParam(':user_type', $userType);
    
        if ($stmt->execute()) {
            $userId = $this->connection->lastInsertId();
            $jwt = $this->generateJWT($userId, $username);
            $userData = [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
                'number' => $number,
                'country' => $country,
                'userType' => $userType,
                'token' => $jwt
            ];
            return $userData;
        } else {
            return false;
        }
    
    }
}
include_once(__DIR__ . '/../Controllers/Signup.php');
class SignupAuth {

    private $SignupController;

    public function __construct() {
        $this->SignupController = new SignupController(); // This should match the class definition
    }

    public function handleSignup(array $postData): void {
        $ipAddress = $postData['ip_address'] ?? null;
        $username = $postData['username'] ?? '';
        $email = $postData['email'] ?? '';
        $number = $postData['number'] ?? '';
        $country = $postData['country'] ?? '';
        $password = $postData['password'] ?? '';
        
        $this->SignupController->setData($username, $email, $number, $country, $password, $ipAddress, 'employee');    

       if ($this->SignupController->checkEmail()) {
        $this->sendResponse(['status' => 'error', 'message' => 'Email already taken.']);
        return; 
    }

        $userId = $this->SignupController->setUser($username,   $email,
        $number,
       $country, $password,$ipAddress,'employee');
 if ($userId) {
    $this->sendResponse(['status' => 'success', 'message' => 'Signup successful', 'userData' => $userId]);
        }
        
        
        else {
            $this->sendResponse(['status' => 'error', 'message' => 'Signup failed. Please try again.']);
        }

       

    }
    
    
    private function sendResponse(array $response): void {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


}

class UserSignup {

    private $data;

    public function __construct() {
        $this->getData();
    }

    

    private function getData() {
        $input = file_get_contents('php://input');
        $this->data = json_decode($input, true) ?? [];
    }

    public function validateSignupData(): ?array {
        $errors = [];

        $requiredFields = ['username', 'email', 'number', 'country', 'password', 'ip_address']; // No 'user_type' here
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(['status' => 'error', 'message' => $field . ' is required.']);
        exit;
    }
}

        if (!empty($errors)) {
            $this->sendResponse(['status' => 'error', 'message' => implode(', ', $errors)]);
            return null;
        }

        // Additional validations
        $username = trim($this->data['username']);
        $email = trim($this->data['email']);
        $number = trim($this->data['number']);
        $country = trim($this->data['country']);
        $password = $this->data['password'];
        $userType = trim($this->data['user_type']);
        
        // Username validation
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 5 || strlen($username) > 20) {
            $errors[] = 'Invalid username format.';
        }

        // Country validation (ensure minimum 2 characters)
        if (strlen($country) < 2) {
            $errors[] = 'Invalid country.';
        }

        // Phone number validation
        if (!preg_match('/^\d{10}$/', $number)) {
            $errors[] = 'Invalid phone number.';
        }

        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format!';
        }

        // Password validation
        $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $errors[] = 'Invalid password format.';
        }

        if (!empty($errors)) {
            $this->sendResponse(['status' => 'error', 'message' => implode(', ', $errors)]);
            return null;
        }

        return ['username' => $username, 'email' => $email, 'number' => $number, 'country' => $country, 'password' => $password,'userType'=> $userType];
    }

    private function sendResponse(array $response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}


