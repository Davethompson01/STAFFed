<?php

namespace App\Controllers;

use App\Models\Job;
use App\Models\User;

class JobController {
    private $jobModel;
    private $userModel;

    public function __construct(Job $jobModel, User $userModel)
    {
        $this->jobModel = $jobModel;
        $this->userModel = $userModel;
    }

    public function createJob($data, $userId)
    {
        // Check if user is an employer
        $user = $this->userModel->getUserById($userId);
        if ($user['user_type'] !== 'employer') {
            return ['status' => 'error', 'message' => 'Only employers can create jobs'];
        }

        // Validate input
        if (empty($data['job_title']) || empty($data['category']) || empty($data['work_mode'])) {
            return ['status' => 'error', 'message' => 'Missing job details'];
        }

        // Create job
        $result = $this->jobModel->createJob($data, $userId);

        return $result ? ['status' => 'success', 'message' => 'Job created successfully'] : ['status' => 'error', 'message' => 'Job creation failed'];
    }
}
