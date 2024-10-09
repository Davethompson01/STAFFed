<?php
namespace App\Models;


require_once(__DIR__ . "/../Models/JobView.php");
require_once(__DIR__ . "/../../config/Database.php");
require_once(__DIR__ . "/../Controllers/JobController.php");
require_once(__DIR__ . "/../Models/Job.php");
use App\Controllers\JobController;
use App\Controllers\JobView;
use App\Models\Job;
use App\Models\User;
use App\Config\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JobRoute {
    private $jobController;
    private $jobView;
    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
    
        // Pass both Job and User models to the JobController
        $this->jobController = new JobController(new Job($db), new User($db));
        $this->jobView = new JobView();
    }

    public function createJob()
        {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? null;
        if (!$authHeader) {
            $this->jobView->render(['status' => 'error', 'message' => 'Token not provided']);
            return;
        }
        $jwtToken = str_replace('Bearer ', '', $authHeader);
        try {
            $decoded = JWT::decode($jwtToken, new Key('your_secret_key', 'HS256'));
            $userId = $decoded->data->id;
            $input = json_decode(file_get_contents('php://input'), true);
            $response = $this->jobController->createJob($input, $userId);
        } catch (\Exception $e) {
            $response = ['status' => 'error', 'message' => 'Invalid token'];
        }

        $this->jobView->render($response);
    }
}
