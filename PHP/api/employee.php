<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); // 
header('Content-Type: application/json');




    require_once(__DIR__ . '/../config/Database.php');
    require_once(__DIR__ . '/../assets/Controllers/signup.php'); 
    function getIpAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            echo $_SERVER['HTTP_CLIENT_IP'];
            return $_SERVER['HTTP_CLIENT_IP'];

        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            echo trim($ips[0]);
            return trim($ips[0]); 
        } else {
            echo   $_SERVER['REMOTE_ADDR'];
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    

    


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $ipAddress = getIpAddress();

        $username = isset($input['username']) ? htmlspecialchars(trim($input['username']), ENT_QUOTES, 'UTF-8') : null;
        $email = isset($input['email']) ? filter_var($input['email'], FILTER_VALIDATE_EMAIL) : null;
        $number = isset($input['number']) ? htmlspecialchars(trim($input['number']), ENT_QUOTES, 'UTF-8') : null;
        $country = isset($input['country']) ? htmlspecialchars(trim($input['country']), ENT_QUOTES, encoding: 'UTF-8') : null;
        $password = isset($input['password']) ? password_hash($input['password'], PASSWORD_BCRYPT) : null;
        $userType = isset($input['user _type']) ? htmlspecialchars(trim($input['user_type']), ENT_QUOTES, 'UTF-8') : null;


        if ($username && $email && $number && $country && $password  &&  $ipAddress) {
           
            // $userType = 'employee';
    
    $signupAuth = new SignupAuth();
    $signupAuth->handleSignup([
        'username' => $username,
        'email' => $email,
        'number' => $number,
        'country' => $country,
        'password' => $password,
        'ip_address' => $ipAddress,
        

            ]);
            // echo json_encode($response);
            if ($signupAuth) {
                echo json_encode(['status' => 'success', 'message' => 'Signup successful']);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert user']);
            }
        } if(empty($username)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'usernameRequired fields are missing.']);
        }if(empty($email)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'email Required fields are missing.']);
        }if(empty($number)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => ' number Required fields are missing.']);
        }if(empty($country)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => ' country Required fields are missing.']);
        }if(empty($password)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => ' pasword Required fields are missing.']);
        }if(empty($userType)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'usertype Required fields are missing.']);
        }
         else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
        }}
     else {
        header("HTTP/1.1 405 Method Not Allowed");
    }

    header('Content-Type: application/json');


    