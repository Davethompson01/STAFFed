<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


require_once(__DIR__ . '/../config/Database.php');
require_once(__DIR__ . '/../assets/Controllers/login.php');

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

// Ensure HTTPS
if ($_SERVER['HTTPS'] !== 'on') {
    echo json_encode(['status' => 'error', 'message' => 'HTTPS is required']);
    exit;
}

// Define an array for blacklisted tokens (you might want to fetch this from your database)
$blacklistedTokens = [];

// Check for POST request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;

    // Validate input data
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Empty email or password']);
        exit;
    }

    // Create a new LoginAuth instance
    $loginAuth = new LoginAuth();

    // Handle login
    $response = $loginAuth->handleLogin($email, $password);

    // Check if the response contains a token
    if (isset($response['token'])) {
        // Check if the token is blacklisted
        if (in_array($response['token'], $blacklistedTokens)) {
            echo json_encode(['status' => 'error', 'message' => 'Token is blacklisted']);
            exit;
        }
        // Return successful response with token
        echo json_encode($response);
    } else {
        // Handle login failure based on the response
        if (isset($response['error'])) {
            echo json_encode(['status' => 'error', 'message' => $response['error']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check authorization header
    if (empty($authHeader)) {
        echo json_encode(['status' => 'error', 'message' => 'Authorization header is required']);
        exit;
    }

    // Get token from authorization header
    $token = explode(' ', $authHeader)[1] ?? '';

    // Check if token is blacklisted
    if (in_array($token, $blacklistedTokens)) {
        echo json_encode(['status' => 'error', 'message' => 'Token is blacklisted']);
        exit;
    }

    // Verify token
    try {
        $decoded = JWT::decode($token, new Key($loginAuth->getSecretKey(), 'HS256')); // Use the Key class
        echo json_encode(['status' => 'success', 'data' => $decoded]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
