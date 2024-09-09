<?php
require_once(__DIR__ . '/../Config/Database.php');
require_once(__DIR__ . '/../assets/Controllers/login.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $loginModel = new LoginModel();
        $loginModel->setData(['email' => $email, 'password' => $password]);
        $user = $loginModel->checkUser();
        
        if (is_array($user)) {
            $response = [
                'status' => 'success',
                'message' => 'Login successful. Welcome, ' . htmlspecialchars($user['user_email']) . '!'
            ];
        
            echo json_encode($response);
        } elseif ($user === "Wrong") {
            // Password is incorrect
            echo json_encode(['status'=>'error',"message"=>'Invalid password']);
        } else {
            // Email does not exist
            echo json_encode(['status'=>'error','message'=>'Invalid email']);
        }
    } else {
         echo json_encode(['status'=>'error','message'=>'Invalid email and password']);
    }
}