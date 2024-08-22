

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__ . '/../../Config/Database.php');

// Define the SignupModel that instantiate the Database class
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
        $query = "SELECT user_firstname FROM staffed_users WHERE CONCAT(first_name, ' ', last_name) = :username;";
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
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':number', $this->number);
    
        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
}

include_once(__DIR__ . '/../Controllers/Signup.php');

class SignupAuth {

    private $signupModel;

    public function __construct() {
        $this->signupModel = new SignupModel(); // This should match the class definition
    }

    public function handleSignup(array $postData): void {
        $username = $postData['username'] ?? '';
        $email = $postData['email'] ?? '';
        $number = $postData['number'] ?? '';
        $country = $postData['country'] ?? '';
        $password = $postData['password'] ?? '';
        
        $this->signupModel->setData($username,   $email,
        $number,
       $country, $password);

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
        if (empty($this->data['username']) || empty($this->data['password']) || empty($this->data['number']) || empty($this->data['email']) || empty($this->data['country'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Username and password are required.']);
            return null;
        }

        $username = trim($this->data['username']);
        $email = trim($this->data['email']);
        $number = trim($this->data['number']);
        $country = trim($this->data['country']);
        $password = trim($this->data['password']);
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 5 || strlen($username) > 20) {
            $this->sendResponse([
                'status' => 'error',
                'message' => 'Invalid username format. Only letters, numbers, and underscores are allowed. Length must be between 5 and 20 characters.'
            ]);
            return null;
        }


        if (strlen($country) < 2) {
            $this->sendResponse([
                'status' => 'error',
                'message' => 'Invalid country. It must be at least 2 characters long.'
            ]);
            return null;
        }

        if (!preg_match('/^\d{10}$/', $number)) {
            $this->sendResponse([
                'status' => 'error',
                'message' => 'Invalid phone number. It must be exactly 10 digits.'
            ]);
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format!";
        }else{
            return !empty($errors) ? $errors : null;
        }
        
        
        
        


        $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $this->sendResponse([
                'status' => 'error', 
                'message' => 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.'
            ]);
            return null;
        }


        return ['username' => $username,'email'=> $email,'number'=>$number,'country'=>$country,'password' => $password];
    }

    private function sendResponse(array $response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
