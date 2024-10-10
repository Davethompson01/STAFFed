<?php

namespace App\Controllers;

use App\Models\JobApplication;

class JobApplicationController {
    private $jobApplicationModel;

    public function __construct(JobApplication $jobApplicationModel) {
        $this->jobApplicationModel = $jobApplicationModel;
    }

    public function applyForJob($job_id, $employee_id) {
        return $this->jobApplicationModel->applyForJob($job_id, $employee_id);
    }

    public function getApplicantsByJob($job_id) {
        return $this->jobApplicationModel->getApplicantsByJob($job_id);
    }

    public function searchEmployees($keyword) {
        return $this->jobApplicationModel->searchEmployees($keyword);
    }
}
