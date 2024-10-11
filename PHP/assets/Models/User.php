<?php


namespace App\Models;


include_once(__DIR__ . '/../../Config/Database.php');

use PDO;

class User{
    private $db;

    public function __construct( $db)
    {
        $this->db = $db;
    }

    public function checkUser($email, $password)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, e.employer_id, emp.employee_id
            FROM staffed_users u
            LEFT JOIN employer e ON u.user_id = e.user_id
            LEFT JOIN employee emp ON u.user_id = emp.user_id
            WHERE u.user_email = :email
        ");
        $stmt->execute(['email' => $email]);
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['user_password'])) {
                return $row; // Ensure this returns 'employee_id' if the user is an employee
            } else {
                return "Wrong";
            }
        } else {
            return null;
        }
    }
    

    public function deleteOldJobsForEmployer($employerId) {
        $query = "DELETE FROM jobs
                  WHERE created_at < NOW() - INTERVAL 2 MONTH 
                  AND employer_id = :employer_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':employer_id', $employerId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    
}