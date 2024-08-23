<?php
include_once(__DIR__ . '/../../Config/Database.php');

class LoginModel {

    private $email;
    private $password;
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function setData($data) {
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function checkUser() {
        $sql = "SELECT * FROM staffed_users WHERE user_email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email' => $this->email]);
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // var_dump($row);
            // exit;
            // Debug output
            error_log("Fetched hash: " . $row['user_password']); // Log the fetched hash
            error_log("Input password: " . $this->password); // Log the input password
    
            if (isset($row['user_password']) && password_verify($this->password, $row['user_password'])) {
                return $row;
            } else {
                return "Wrong";
            }
        } else {
            return null;
        }
    }
    
    
}
