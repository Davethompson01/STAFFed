<?php

namespace App\Models;

use PDO;

require_once __DIR__ . "/../../config/Database.php";
use App\Config\Database;

class JobApplication {
    private $db;
    private $table = "applications"; 

    public function __construct() {
        
        $this->db = (new Database())->getConnection();
    }

    
    public function applyForJob($job_id, $employee_id) {
    
        $query = "SELECT * FROM employee WHERE employee_id = :employee_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$employee) {
            return ['status' => 'error', 'message' => 'Only employees can apply for jobs'];
        }

       
        $query = "INSERT INTO " . $this->table . " (job_id, employee_id) VALUES (:job_id, :employee_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Job application successful'];
        }

        return ['status' => 'error', 'message' => 'Failed to apply for the job'];
    }

   
    public function getApplicantsByJob($job_id) {
        $query = "SELECT employee.employee_id, employee.username, employee.user_email FROM " . $this->table . "
                  JOIN employee ON employee.employee_id = " . $this->table . ".employee_id
                  WHERE " . $this->table . ".job_id = :job_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function searchEmployees($keyword) {
        $query = "SELECT * FROM employee WHERE name LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppliedJobsByEmployee($employee_id) {
        $query = "SELECT jobs.job_id,jobs.price,jobs.job_category,jobs.company_name,jobs.job_title,jobs.work_mode,jobs.job_location,jobs.resume_url,jobs.job_description,jobs.requirement,jobs.time_created,jobs.applications_count,jobs.employee_id,jobs.employer_id

              FROM " . $this->table . "
              JOIN jobs ON jobs.job_id = " . $this->table . ".job_id
              WHERE " . $this->table . ".employee_id = :employee_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $appliedJobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'status' => 'success',
            'message' => 'Fetched applied jobs successfully',
            'data' => $appliedJobs
        ];
    }
    
}
