<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
use \Firebase\JWT\JWT;
require_once(__DIR__ . '/../config/Database.php');
require_once(__DIR__ . '/../assets/Controllers/login.php');
require_once(__DIR__. "/../composer/vendor/autoload.php");

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Empty email or Password']);
        exit;
      }
    if ($email && $password) {
        $loginModel = new LoginModel();
        $loginModel->setData(['email' => $email, 'password' => $password]);
        $user = $loginModel->checkUser();
        if (is_array($user)) {
            
            $secret_key = "1234Staffed";
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600;
            $payload = array(
                "iss" => "your_domain.com",
                "iat" => $issuedAt,
                "exp" => $expirationTime,
                "data" => array(
                    "id" => $user['user_id'],
                    "username" => $user['username']
                )
            );
            $jwt = JWT::encode($payload, $secret_key, 'HS256');
            $response = [
                'status' => 'success',
      'message' => 'Login successful.',
      'token' => $jwt,
      'user_details' => $user  
            ];
            echo json_encode($response);
        } elseif ($user === "Wrong") {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email and password']);
    }
}
