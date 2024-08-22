<?php
class SignupModel {

    private $username;
    private $email;
    private $number;
    private $country;
    private $password;
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function setData($username, $email, $number, $country, $password) {
        $this->username = htmlspecialchars(trim($username), ENT_QUOTES, 'UTF-8');
        $this->email = htmlspecialchars(trim($email), ENT_QUOTES, 'UTF-8');
        $this->number = trim($number);
        $this->country = trim($country);
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function checkUsername() {
        $query = "SELECT username FROM staffed_users WHERE username = :username;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function setUser() {
        $query = "INSERT INTO staffed_users (username, user_email, user_password, user_country, user_phoneNumber) VALUES (:username, :email, :password, :country, :number);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':number', $this->number);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
}
