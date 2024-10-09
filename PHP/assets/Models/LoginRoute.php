<?php

namespace App\Models;

require_once(__DIR__ . "/../../config/Database.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/../Controllers/LoginView.php");
use App\Controllers\LoginController;
use App\Models\User;
use App\Controllers\LoginView;
use App\Config\Database;


class LoginRoute{
    private $loginController;
    private $database;
    private $loginView;

    public function __construct()
    {
        $this->database = new Database();
$this->database = $this->database->getConnection(); // Use the getConnection method

        $this->loginController = new LoginController(new User($this->database));
        $this->loginView = new LoginView();
    }

    public function handleLogin()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? null;
        $password = $input['password'] ?? null;

        if (empty($email) || empty($password)) {
            $response = ['status' => 'error', 'message' => 'Empty email or password'];
        } else {
            $response = $this->loginController->handleLogin($email, $password);
        }

        $this->loginView->render($response);
    }
}
