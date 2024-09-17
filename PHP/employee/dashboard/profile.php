<?php

require_once (__DIR__. "/../../Signup_Login/assets/Controllers/profile.php");
require_once (__DIR__. "/../../Signup_Login/assets/Models/profile.php");

// routes.php (or index.php depending on your setup)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController(new UserModel($database));
    $controller->uploadImage();
}
