<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require_once(__DIR__ . '/../Config/Database.php');
require_once(__DIR__ . '/../assets/Controllers/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;

    if ($email && $password) {
        $loginModel = new LoginModel();
        $loginModel->setData(['email' => $email, 'password' => $password]);
        $user = $loginModel->checkUser();

        if (is_array($user)) {
            session_start();  // Start the session
            $_SESSION['user_id'] = $user['user_id'];  // Set the session only if user is valid
            
            $response = [
                'status' => 'success',
                'message' => 'Login successful', 
                'token' => $user['user_token']  // Send the user token back
            ];

            echo json_encode($response);
        } elseif ($user === "Wrong") {
            // Password is incorrect
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        } else {
            // Email does not exist
            echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email and password']);
    }
}
