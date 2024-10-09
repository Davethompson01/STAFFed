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
        $stmt = $this->db->prepare("SELECT * FROM staffed_users WHERE user_email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['user_password'])) {
                return $row;
            } else {
                return "Wrong";
            }
        } else {
            return null;
        }
    }
}