<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../assets/Routes/JobRoute.php';

use App\Models\JobRoute;

$jobRoute = new JobRoute();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $jobRoute->createJob();
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
