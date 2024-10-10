<?php

namespace App\Models;

use PDO;

require_once __DIR__ . "/../../config/Database.php";
use App\Config\Database;

class JobApplication {
    private $db;
    private $table = "job_applications";

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function applyForJob($job_id, $employee_id) {
        // Check if user is an employee
        $query = "SELECT * FROM employees WHERE employee_id = :employee_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            return ['status' => 'error', 'message' => 'Only employees can apply for jobs'];
        }

        // Apply for the job
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
        $query = "SELECT employees.employee_id, employees.name, employees.email FROM " . $this->table . "
                  JOIN employees ON employees.employee_id = job_applications.employee_id
                  WHERE job_applications.job_id = :job_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchEmployees($keyword) {
        $query = "SELECT * FROM employees WHERE name LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
