<?php

namespace App\Models;

use PDO;

require_once __DIR__ . "/../../config/Database.php";
use App\Config\Database;

class Job {
    private $db;
    private $table = "jobs";

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function createJob($price, $job_category, $company_name, $job_title, $work_mode, $job_location, $resume_url, $job_description, $requirement, $employer_id, $employee_id) {
        
        $jobData = [
            'price' => $price,
            'job_category' => $job_category,
            'company_name' => $company_name,
            'job_title' => $job_title,
            'work_mode' => $work_mode,
            'job_location' => $job_location,
            'resume_url' => $resume_url,
            'job_description' => $job_description,
            'requirement' => $requirement,
            'employer_id' => $employer_id,
        ];

        foreach ($jobData as $key => $value) {
            if (empty($value)) {
                return ['status' => 'error', 'message' => ucfirst($key) . ' cannot be empty'];
            }
        }

     
        $query = "INSERT INTO " . $this->table . " 
        (price, job_category, company_name, job_title, work_mode, job_location, resume_url, job_description, requirement, employer_id, employee_id)
        VALUES (:price, :job_category, :company_name, :job_title, :work_mode, :job_location, :resume_url, :job_description, :requirement, :employer_id, :employee_id)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':job_category', $job_category);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':job_title', $job_title);
        $stmt->bindParam(':work_mode', $work_mode);
        $stmt->bindParam(':job_location', $job_location);
        $stmt->bindParam(':resume_url', $resume_url);
        $stmt->bindParam(':job_description', $job_description);
        $stmt->bindParam(':requirement', $requirement);
        $stmt->bindParam(':employer_id', $employer_id);
        $stmt->bindParam(':employee_id', $employee_id);

        if ($stmt->execute()) {
            
            return ['status' => 'success', 'message' => 'Job created successfully'];
        }

        return ['status' => 'error', 'message' => 'Failed to create job'];
    }

    public function getJobsByEmployer($employerId) {
        $query = "SELECT * FROM " . $this->table . " WHERE employer_id = :employer_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':employer_id', $employerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
