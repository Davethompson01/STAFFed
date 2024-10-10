<?php

namespace App\Models;

require_once __DIR__ . "/../Controllers/JobController.php";
require_once __DIR__ . "/../Models/Job.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Controllers\JobController;

class JobRoute {
    private $jobController;
    private $jwtSecret = "1234Staffed"; // Use the same secret used to sign the JWT
    public function __construct() {
        $this->jobController = new JobController(new Job());
    }

    // Function to get the token from the Authorization header
    private function getBearerToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            list($jwt) = sscanf($authHeader, 'Bearer %s');
        
            if ($jwt) {
                return $jwt;  // Return the token
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Missing token']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Missing Authorization header']);
            exit();
        }
    }

    // Function to decode the JWT and retrieve user details
    private function getUserFromToken() {
        $token = $this->getBearerToken();
        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
                // print_r($decoded); // Add this line to debug the token payload
                return $decoded->data;  // Assuming 'data' contains the employer_id
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid token: ' . $e->getMessage()]);
                exit();
            }
        }
        return null;
    }
    

    public function createJob() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Get employer_id from JWT token
        $user = $this->getUserFromToken();
        if (!$user) {
            return ['status' => 'error', 'message' => 'Invalid or missing token'];
        }

        $employer_id = $user->employer_id ?? null;

        // Allow only employers to create jobs
        if (empty($employer_id)) {
            return ['status' => 'error', 'message' => 'Only employers can create jobs'];
        }

        // Extract job details from the input
        $price = $input['price'] ?? null;
        $job_category = $input['job_category'] ?? null;
        $company_name = $input['company_name'] ?? null;
        $job_title = $input['job_title'] ?? null;
        $work_mode = $input['work_mode'] ?? null;
        $job_location = $input['job_location'] ?? null;
        $resume_url = $input['resume_url'] ?? null;
        $job_description = $input['job_description'] ?? null;
        $requirement = $input['requirement'] ?? null;

        // Validate required fields
        if (empty($job_category) || empty($work_mode)) {
            return ['status' => 'error', 'message' => 'Missing required fields'];
        }

        // Call the controller to handle job creation
        return $this->jobController->handleCreateJob(
            $price, $job_category, $company_name, $job_title,
            $work_mode, $job_location, $resume_url, $job_description,
            $requirement, $employer_id, null
        );
    }
}
