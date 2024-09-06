<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Allow your React app's origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow the methods you need
header("Access-Control-Allow-Headers: Content-Type"); // Allow the headers you need
header('Content-Type: application/json');

    require_once(__DIR__ . '/../config/Database.php');
    require_once(__DIR__ . '/../assets/Models/signup.php');
    require_once(__DIR__ . '/../assets/Controllers/signup.php');


   	

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8') : null;
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
        $number = isset($_POST['number']) ? htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8') : null;
        $country = isset($_POST['country']) ? htmlspecialchars(trim($_POST['country']), ENT_QUOTES, 'UTF-8') : null;
        $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8') : null;

        if ($username && $email && $number && $country && $password) {
            $signupAuth = new SignupAuth();
              $signupAuth->handleSignup([
                'username' => $username,
                'email' => $email,
                'number' => $number,
                'country' => $country,
                'password' => $password
            ]);
            // echo json_encode($response);
            if ($signupAuth) {
                echo json_encode(['status' => 'success', 'message' => 'Signup successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert user']);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
        }
    } else {
        header("HTTP/1.1 405 Method Not Allowed");
    }

    header('Content-Type: application/json');
// echo json_encode($response);
