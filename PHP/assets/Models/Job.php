<?php

namespace App\Models;

use PDO;

class Job {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createJob($data, $employerId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jobs (employer_id, job_title, category, work_mode)
            VALUES (:employer_id, :job_title, :category, :work_mode)
        ");

        return $stmt->execute([
            'employer_id' => $employerId,
            'job_title' => $data['job_title'],
            'category' => $data['category'],
            'work_mode' => $data['work_mode']
        ]);
    }

    public function countApplicants($jobId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as applicants_count FROM applications WHERE job_id = :job_id");
        $stmt->execute(['job_id' => $jobId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
