<?php
require_once(__DIR__ . '/../Config/Database.php');
require_once(__DIR__ . '/../assets/Models/Login.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $loginModel = new LoginModel();
        $loginModel->setData(['email' => $email, 'password' => $password]);
        $user = $loginModel->checkUser();

        if (is_array($user)) {
            // User authenticated successfully
            echo "Login successful. Welcome, " . htmlspecialchars($user['user_email']) . "!";
        } elseif ($user === "Wrong") {
            // Password is incorrect
            echo "Invalid from David";
        } else {
            // Email does not exist
            echo "Invalid email or password.";
        }
    } else {
        echo "Email and password are required.";
    }
}
