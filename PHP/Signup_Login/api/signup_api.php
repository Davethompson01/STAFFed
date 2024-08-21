<?php
include_once('../src/Controllers/SignupController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username and password are required.']);
        exit();
    }

    $signin = new SignupAuth();
    $signin->handleSignup($_POST);

    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


