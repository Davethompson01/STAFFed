<?php
include_once (__DIR__ . '/../Models/Login.php');

class LoginAuth {

    private $userLogin;
    private $loginModel;

    public function __construct() {
        $this->userLogin = new UserLogin();
        $this->loginModel = new LoginModel();
    }

    public function handleLogin() {
        $cleanedData = $this->userLogin->cleanData();
        
        if ($cleanedData) {
            $this->loginModel->setData($cleanedData);
            $user = $this->loginModel->checkUser();
            if ($user) {
                $this->sendResponse(['status' => 'success', 'message' => 'Login successful.', 'user_details' => $user]);
                echo json_encode($user);
            } else {
                $this->sendResponse(['status' => 'error', 'message' => 'Invalid username or password.']);
            }
        }
    }

    private function sendResponse($response) {
        header('Content-Type: application/json');
        echo json_encode($response);
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
        if (empty($this->data['username'])) {
            $this->sendResponse(['status' => 'error', 'message' => 'Invalid input. Username is required.']);
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
