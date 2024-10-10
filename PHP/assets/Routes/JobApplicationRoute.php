<?php

require_once __DIR__ . "/../Controllers/JobApplicationController.php";

use App\Controllers\JobApplicationController;
use App\Models\JobApplication;

$jobApplicationModel = new JobApplication();
$jobApplicationController = new JobApplicationController($jobApplicationModel);

// Apply for a job (POST request)


// Get applicants for a job (GET request)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $applicants = $jobApplicationController->getApplicantsByJob($job_id);
    echo json_encode($applicants);
}

// Search employees (GET request)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $employees = $jobApplicationController->searchEmployees($keyword);
    echo json_encode($employees);
}
