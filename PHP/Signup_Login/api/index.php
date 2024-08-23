<?php
require_once(__DIR__ . '/../config/Database.php');
require_once(__DIR__ . '/../assets/Models/signup.php'); // Make sure this path is correct

if (isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $number = isset($_POST['number']) ? $_POST['number'] : null;
    $country = isset($_POST['country']) ? $_POST['country'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($username && $email && $number && $country && $password) {
        // include(__DIR__ . '/Signup_Login/assets/Models/signup.php'); 
        $signup = new SignupModel();

        // Set user data
        $signup->setData($username, $email, $number, $country, $password);

        // Try to insert the user
        $result = $signup->setUser();
        
        if ($result !== false) {
            echo "Good";
            exit();
        } else {
            header("Location: ./insert.html?error=" . urlencode('Failed to insert user.')); // Return a generic error message
            exit();
        }
    } else {
        // Handle missing form data
        header("Location: ./insert.html?error=" . urlencode('Required fields are missing.'));
        exit();
    }
}
