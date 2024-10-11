<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Require necessary files
require_once __DIR__ . "/../assets/Models/JobApplication.php";
require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload for JWT

use App\Models\JobApplication;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Initialize the JobApplication model
$getapplied = new JobApplication();

// Get the Authorization header and decode JWT token
$headers = getallheaders();
if (isset($headers['Authorization'])) {
    $jwt = str_replace('Bearer ', '', $headers['Authorization']); // Remove "Bearer " from token if present
    $secret_key = '1234Staffed'; // Your secret key
    
    try {
        // Decode the JWT token
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
        
        // Check if employee_id exists in the token payload
        if (isset($decoded->data->employee_id)) {
            $employee_id = $decoded->data->employee_id;

            // Get applied jobs for this employee, including job details
            $result = $getapplied->getAppliedJobsByEmployee($employee_id);
            echo json_encode($result); // Return the result as a JSON response
        } else {
            echo json_encode(['status' => 'error', 'message' => 'employee_id not found in JWT']);
        }
    } catch (Exception $e) {
        // Handle JWT decoding error
        error_log("Token decode error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Invalid token: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Authorization header missing']);
}
