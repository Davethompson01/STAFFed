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
$jobApplication = new JobApplication();

// Get headers and check for Authorization
$headers = getallheaders();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($headers['Authorization'])) {
        $jwt = str_replace('Bearer ', '', $headers['Authorization']); // Remove "Bearer " from token if present
        $secret_key = '1234Staffed'; // Your secret key
        
        try {
            // Decode the JWT token
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

            // Check if employer_id exists in the token (assuming you store employer_id in JWT)
            if (isset($decoded->data->employer_id)) {
                
                $inputData = json_decode(file_get_contents("php://input"), true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON received']);
                    exit;
                }

                
                if (empty($inputData)) {
                    echo json_encode(['status' => 'error', 'message' => 'No input data received']);
                    exit;
                }

               

                if (isset($inputData['job_id'])) {
                    $job_id = $inputData['job_id'];

                    // Get the list of applicants for the specified job
                    $result = $jobApplication->getApplicantsByJob($job_id);
                    echo json_encode($result); // Return the result as a JSON response
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Job ID is missing']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'employer_id not found in JWT']);
            }
        } catch (Exception $e) {
            // Handle JWT decoding error
            error_log("Token decode error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Invalid token: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Authorization header missing']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed']);
}
