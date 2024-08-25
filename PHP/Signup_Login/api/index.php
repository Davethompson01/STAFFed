<?php
// require_once(__DIR__ . '/../config/Database.php');
// require_once(__DIR__ . '/../assets/Models/signup.php'); // Make sure this path is correct
// require_once(__DIR__) . '/../assets/Controllers/signup.php';
// if (isset($_POST['submit'])) {

    

// $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8') : null;
// $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
// $number = isset($_POST['number']) ? htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8') : null;
// $country = isset($_POST['country']) ? htmlspecialchars(trim($_POST['country']), ENT_QUOTES, 'UTF-8') : null;
// $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8') : null;

    
//     if ($username && $email && $number && $country && $password) {
//         // include(__DIR__ . '/Signup_Login/assets/Models/signup.php'); 
//         $signup = new UserSignup();

//         // Set user data
//         $validatedData = $signup->validateSignupData();
//         // Try to insert the user
//         $result = $signup->validateSignupData();
        
//         if ($result !== false) {
//             header(__DIR__ . '/../../../src/Pages/SignUp.jsx');
//             // exit();
//         } else {
//             header("Location: ./insert.html?error=" . urlencode('Failed to insert user.')); // Return a generic error message
//             exit();
//         }
//     } else {
//         // Handle missing form data
//         header("Location: ./insert.html?error=" . urlencode('Required fields are missing.'));
//         exit();
//     }
// }


require_once(__DIR__ . '/../config/Database.php');
require_once(__DIR__ . '/../assets/Models/signup.php');
require_once(__DIR__ . '/../assets/Controllers/signup.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8') : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $number = isset($_POST['number']) ? htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8') : null;
    $country = isset($_POST['country']) ? htmlspecialchars(trim($_POST['country']), ENT_QUOTES, 'UTF-8') : null;
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8') : null;

    if ($username && $email && $number && $country && $password) {
        $signupAuth = new SignupAuth();
        $signupAuth->handleSignup([
            'username' => $username,
            'email' => $email,
            'number' => $number,
            'country' => $country,
            'password' => $password
        ]);
        
    } else {
        header("Location: ./insert.html?error=" . urlencode('Required fields are missing.'));
        exit();
    }
}
?>
