<?php
include_once(__DIR__ . '/../../Config/Database.php');

// Define the SignupModel that instantiate the Database class
class SignupModel {

    private $username;
    private $email;
    private $number;
    private $country;
    private $password;
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function setData($username, $email,$number,$country,$password) {
        $this->username = htmlspecialchars(trim($username), ENT_QUOTES, 'UTF-8');
        $this->password = htmlspecialchars(trim($email), ENT_QUOTES, 'UTF-8');
        $this->password = trim($number);
        $this->password = trim($country);
        $this->password = password_hash($password,PASSWORD_BCRYPT);
    }

    public function checkUsername() {
        // Concatenate first_name and last_name to check against the username
        $query = "SELECT user_firstname FROM staffed_users WHERE CONCAT(first_name, ' ', last_name) = :username;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    

    public function setUser() {
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        
        $query = "INSERT INTO staffed_users (username,	user_email,	user_password	,user_country	,user_phoneNumber) VALUES (?,?,?,?,?,?);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':country', $this->number);
        $stmt->bindParam(':number', $this->country);
        $stmt->bindParam(':password', $hashedPassword);
        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
}

include_once(__DIR__ . '/../Controllers/SignupController.php');

class SignupAuth {

    private $signupModel;

    public function __construct() {
        $this->signupModel = new SignupModel();
    }

    public function handleSignup(array $postData): void {
        $username = $postData['username'] ?? '';
        $password = $postData['password'] ?? '';
        $password = $postData['password'] ?? '';
        $password = $postData['password'] ?? '';
        $password = $postData['password'] ?? '';
        
        $this->signupModel->setData($username, $password);

        if ($this->signupModel->checkUsername()) {
            $this->sendResponse(['status' => 'failed', 'message' => 'Username already taken.']);
            return;
        }

        $userId = $this->signupModel->setUser();

        if ($userId !== false) {
            $this->sendResponse(['status' => 'success', 'message' => 'Signup successful.', 'userId' => $userId]);
        } else {
            $this->sendResponse(['status' => 'failed', 'message' => 'Signup failed. Please try again.']);
        }
    }
    
    private function sendResponse(array $response): void {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Ensure that no further output is sent
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
        if (empty($this->data['username']) || empty($this->data['password'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Username and password are required.']);
            return null;
        }

        $username = trim($this->data['username']);
        $password = trim($this->data['password']);
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 5 || strlen($username) > 20) {
            $this->sendResponse([
                'status' => 'error',
                'message' => 'Invalid username format. Only letters, numbers, and underscores are allowed. Length must be between 5 and 20 characters.'
            ]);
            return null;
        }

        $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $this->sendResponse([
                'status' => 'error', 
                'message' => 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]);
            return null;
        }

        return ['username' => $username, 'password' => $password];
    }

    private function sendResponse(array $response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
