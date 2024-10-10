<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once __DIR__ . "/../assets/Routes/JobApplicationRoute.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply'])) {
    $job_id = $_POST['job_id'];
    $employee_id = $_POST['employee_id'];
    $result = $jobApplicationController->applyForJob($job_id, $employee_id);
    echo json_encode($result);
}