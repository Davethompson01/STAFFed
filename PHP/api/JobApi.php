<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . "/../assets/Routes/JobRoute.php");

use App\Models\JobRoute;
$jobRoute = new JobRoute();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $jobRoute->createJob();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
