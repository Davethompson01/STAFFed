

<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once(__DIR__ . '/../../Config/Database.php');

// Define the SignupMo
class SignupController  {

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
        $this->email = htmlspecialchars(trim($email), ENT_QUOTES, 'UTF-8');
        $this->number = trim($number);
        $this->country = trim($country);
        $this->password = password_hash($password,PASSWORD_BCRYPT);
    }

    public function checkUsername() {
        // Concatenate first_name and last_name to check against the username
        $query = "SELECT username FROM staffed_users WHERE  username = :username;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    

    public function setUser() {
        $query = "INSERT INTO staffed_users (username, user_email, user_password, user_country, user_phoneNumber) VALUES (:username, :email, :password, :country, :number);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':number', $this->number);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        }
        else{
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
        $username = $postData['username'] ?? '';
        $email = $postData['email'] ?? '';
        $number = $postData['number'] ?? '';
        $country = $postData['country'] ?? '';
        $password = $postData['password'] ?? '';
        
        $this->SignupController->setData($username,   $email,
        $number,
       $country, $password);

       if ($this->SignupController->checkUsername()) {
        $this->sendResponse(['status' => 'error', 'message' => 'Username already taken.']);
        return; // Stop executi
    }

        $userId = $this->SignupController->setUser();
 if ($userId !== false) {
            $this->sendResponse(['status' => 'success', 'message' => 'Signup successful']);
        } else {
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

        // error_log('Raw input: ' . $input);
        // error_log('Decoded data: ' . print_r($this->data, true));
    }

    public function validateSignupData(): ?array {
        $errors = [];
    
        // Check for missing fields
        $requiredFields = ['username', 'password', 'number', 'email', 'country'];
        foreach ($requiredFields as $field) {
            if (empty($this->data[$field])) {
                $errors[] = ucfirst($field) . ' is required.';
            }
        }
    
        if (!empty($errors)) {
            $this->sendResponse(['status' => 'error', 'message' => implode(', ', $errors)]);
            return null;
        }
    
        $username = trim($this->data['username']);
        $email = trim($this->data['email']);
        $number = trim($this->data['number']);
        $country = trim($this->data['country']);
        $password = trim($this->data['password']);
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 5 || strlen($username) > 20) {
            $errors[] = 'Invalid username format.';
        }
    
        if (strlen($country) < 2) {
            $errors[] = 'Invalid country.';
        }
    
        if (!preg_match('/^\d{10}$/', $number)) {
            $errors[] = 'Invalid phone number.';
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format!';
        }
    
        $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $errors[] = 'Invalid password format.';
        }
    
        if (!empty($errors)) {
            $this->sendResponse(['status' => 'error', 'message' => implode(', ', $errors)]);
            return null;
        }
        
        return ['username' => $username, 'email' => $email, 'number' => $number, 'country' => $country, 'password' => $password];
    }
    

    private function sendResponse(array $response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
