<?php
include_once(__DIR__ . '/../../Signup_Login/assets/Controllers/signup.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $number = $_POST['user_number'] ?? '';
    $country = $_POST['country'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password) || empty($email) || empty($country) || empty($number))  {
        echo json_encode(['status' => 'error', 'message' => 'Username and password are required.']);
        exit();
    }

    $signin = new SignupAuth();
    $signin->handleSignup($_POST);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


