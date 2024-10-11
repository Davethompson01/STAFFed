<?php

namespace App\Controllers;

use App\Models\Job;

class JobController {
    private $jobModel;

    public function __construct(Job $jobModel) {
        $this->jobModel = $jobModel;
    }

    public function handleCreateJob($price, $job_category, $company_name, $job_title, $work_mode, $job_location, $resume_url, $job_description, $requirement, $employer_id, $employee_id) {
       
        $result = $this->jobModel->createJob($price, $job_category, $company_name, $job_title, $work_mode, $job_location, $resume_url, $job_description, $requirement, $employer_id, $employee_id);

        if ($result['status'] === 'success') {
            
            return $this->getJobsByEmployer($employer_id);
        } else {
            
            return ['status' => 'error', 'message' => $result['message']];
        }
    }

    public function getJobsByEmployer($employerId) {

        $jobs = $this->jobModel->getJobsByEmployer($employerId);
        
        if (!empty($jobs)) {
            return ['status' => 'success', 'data' => $jobs];
        } else {
            return ['status' => 'error', 'message' => 'No jobs found for this employer'];
        }
    }
}
