<?php
namespace cUtils;

 // Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
use \PDO;
use Exception;
use PDOException;
use \db\db;
use \Consts\Consts;
use Users\Users;
use mUtils\mUtils;

/**
 * 
 */
class cUtils
{


    # DECODE THE HTMLSPECIAL STRING IN TO STRING
# -----------------------------------------------------------------------*/
public static function escape_data($data){
  //$con=mysqli_connect(DB_SERVER,DBASE_USER,DBASE_PASS,DBASE_NAME);
  $mysqli = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(function_exists('mysql_real_escape_string')){
    $data = mysqli_real_escape_string($mysqli, $data);
    $data = strip_tags($data);
  }else{
    $data = trim($data);
    $data = mysqli_escape_string($mysqli, $data);
    $data = strip_tags($data);
  }
  return $data;
  mysqli_close($mysqli);
}
# ---------------------------------------------------------------------


public static function get_ip_info(){
  $indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWAY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;
$result ="";
$result = $result . '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        $result = $result . '<tr><td>'.$arg.'</td><td> __ ' . $_SERVER[$arg] . ' </td> </tr>' ;
    }
    else {
        $result = $result .'<tr><td>'.$arg.'</td><td>__</td> </tr>' ;
    }
}
$result = $result .'</table>' ;
return $result;
}


public static function sql_detect($data){
    $sql = array(
    "DROP DATABASE",
    "ALTER TABLE",
    "TRUNCATE TABLE",
    "DELETE FROM",
    "INSERT INTO",
    "DROP TABLE",
    "CREATE TABLE"
    );

    $str  = strtoupper($data);
    $count = count($sql);
    $b="";

    for ($i=0; $i < $count; $i++) {
      $pos = strpos($str, $sql[$i]);
      if ($pos === false) {
        $b= FALSE;
      }else{
        $b= TRUE;
        break;
      }
    }

    if ($b == false) {
      return FALSE;
    }else{
      return TRUE;
    }
}


public static function sql_offence($data){
        $data = escape_data($data);
        $data = str_replace(" ", "_", $data);
        $data = "__".$data."__";
        return $data;
}


public static function attack_detect($offence,$mem_id){
    $con=mysqli_connect(DB_SERVER,DBASE_USER,DBASE_PASS,DBASE_NAME);
     $ip_info = escape_data(get_ip_info());
      $offence = escape_data($offence);
     if(empty($memid)){
      $memid = "UN-KNOWN";
     }

    $sql = " insert into db_offence_tb (ip_address ,timestamp ,ip_info,offence,user_id,dir_url) values ('".get_client_ip()."','". date("F j, Y, D, h:i a")."','".$ip_info."','$offence','$memid','$realurl')";
    mysqli_query($con,$sql);

      $subject = 'THREAT ALERT';

      $email = "ayodeletim@gmail.com" ;
      //-----
        $from = "$webmail3";
        //-----

        $Server ="";
        $headers = "From: $Server <".$from.">\n";
        $headers .= "Reply-To: $Server <".$from.">\n";
        $headers .= "Return-Path: $Server <".$from.">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $message = msg_html("<h2>$offence<h2> </br>" . get_ip_info());

        mail($email, $subject, $message, $headers);

}


public static function input_check($data){

if (!is_array($data)) {
    if (strpos($data, '"')) {
        $data = str_replace('"', '', $data);
    }
}
    
    $data = trim($data);
  if(self::sql_detect($data) ==TRUE){
    $offence = sql_offence($data);
    attack_detect($offence);
    return "****";
  }else{
    $data = trim($data);
    $data = filter_var($data, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
    $data = strip_tags($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data , ENT_QUOTES,'UTF-8');
    $data = self::escape_data($data);

    return $data;
  }

}


public static function input_check_large($data){
  if(sql_detect($data) ==TRUE){
    $offence = sql_offence($data);
    attack_detect($offence);
    return "****";
  }else{
    $data = trim($data);
    $data = filter_var($data, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
   // $data = strip_tags($data);
   // $data = stripslashes($data);
 //   $data = htmlspecialchars($data , ENT_QUOTES,'UTF-8');
    $data = escape_data($data);

/*
      $subject = 'THREAT ALERT';

      $email = "ayodeletim@gmail.com" ;
      //-----
        $from = "$webmail3";
        //-----

        $Server ="jhfhfjhfh";
        $headers = "From: $Server <".$from.">\n";
        $headers .= "Reply-To: $Server <".$from.">\n";
        $headers .= "Return-Path: $Server <".$from.">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $message = msg_html("<h2>$offence<h2> </br>" . get_ip_info());

        mail($email, $subject, $message, $headers);
*/
    return $data;
  }

}


public static function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    $ipaddress = $_SERVER['SERVER_ADDR'] ;
    return $ipaddress;
}


public static function datediff ($olddate, $newdate){

// Declare and define two dates 
// $date1 = strtotime("2016-06-01 22:45:00"); 
// $date2 = strtotime("2018-09-21 10:44:01"); 

// Formulate the Difference between two dates 
  $newdate = intval($newdate);
  $olddate = intval($olddate);
$diff = abs($newdate - $olddate); 


// To get the year divide the resultant date into 
// total seconds in a year (365*60*60*24) 
$years = floor($diff / (365*60*60*24)); 


// To get the month, subtract it with years and 
// divide the resultant date into 
// total seconds in a month (30*60*60*24) 
$months = floor(($diff - $years * 365*60*60*24) 
              / (30*60*60*24)); 


// To get the day, subtract it with years and 
// months and divide the resultant date into 
// total seconds in a days (60*60*24) 
$days = floor(($diff - $years * 365*60*60*24 - 
      $months*30*60*60*24)/ (60*60*24)); 


// To get the hour, subtract it with years, 
// months & seconds and divide the resultant 
// date into total seconds in a hours (60*60) 
$hours = floor(($diff - $years * 365*60*60*24 
  - $months*30*60*60*24 - $days*60*60*24) 
                / (60*60)); 


// To get the minutes, subtract it with years, 
// months, seconds and hours and divide the 
// resultant date into total seconds i.e. 60 
$minutes = floor(($diff - $years * 365*60*60*24 
    - $months*30*60*60*24 - $days*60*60*24 
            - $hours*60*60)/ 60); 


// To get the minutes, subtract it with years, 
// months, seconds, hours and minutes 
$seconds = floor(($diff - $years * 365*60*60*24 
    - $months*30*60*60*24 - $days*60*60*24 
        - $hours*60*60 - $minutes*60)); 

// Print the result 
// printf("%d years, %d months, %d days, %d hours, "
//   . "%d minutes, %d seconds", $years, $months, 
//       $days, $hours, $minutes, $seconds); 

if ($years!='') {
  # code...
  // $value = "$years years, $months months, $days days, $hours hours, $minutes minutes, $seconds seconds";
   $value = "$years year(s)";
  return $value;
}elseif ($months!='') {
  # code...
  // $value = "$months months, $days days, $hours hours, $minutes minutes, $seconds seconds";
   $value = "$months month(s)";
  return $value;
}elseif ($days!='') {
  # code...
  // $value = "$days days, $hours hours, $minutes minutes, $seconds seconds";
  $value = "$days day(s)";
  return $value;
}elseif ($hours!='') {
  # code...
  // $value = "$hours hours, $minutes minutes, $seconds seconds";
   $value = "$hours hour(s)";
  return $value;
}elseif ($minutes!='') {
  # code...
  // $value = "$minutes minutes, $seconds seconds";
  $value = "$minutes minute(s)";
  return $value;
}elseif ($seconds!='') {
  # code...
  $value = "$seconds second(s)";
  return $value;
}
}

// Function to generate OTP 
public static function generateNumericOTP($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
} 

public static function generateAlphaNumericOTP($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
} 


public static function generateAlphaNumericOTP_($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
} 


public static function generateAlphaNumericOTP_case($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
} 



public static function generateAlphaNumericOTP_case_($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
} 




public static function generateAlphaOTP($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
}




public static function generateAlphaNumericOTP_case_char($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "1357902468ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@#_+"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
}



public static function generateCharOTP($n) { 
      
    // Take a generator string which consist of 
    // all numeric digits 
    $generator = "-(@#_+)%!&=$?><"; 
  
    // Iterate for n-times and pick a single character 
    // from generator and append it to $result 
      
    // Login for generating a random character from generator 
    //     ---generate a random number 
    //     ---take modulus of same with length of generator (say i) 
    //     ---append the character at place (i) from generator to result 
  
    $result = ""; 
  
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    return $result; 
}



public function sendEmailiygyguygi ($email,$subject,$body,$timestamp){

    // create a new object
    $mail = new PHPMailer();

    // configure an SMTP
    $mail->isSMTP();
    $mail->Host = 'business147.web-hosting.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@renitrust.com';
    $mail->Password = 'C^k+xGz^X^II';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('no-reply@renitrust.com', ''.$this->const->PlatformName().'');
$dbname = "ReniTrust";
$mail2 = clone $mail;
    $mail2->addAddress($email, $dbname);
   $mail2->addReplyTo(''.$this->const->PlatformEmail().'', ''.$this->const->PlatformName().'');
    $mail2->Subject = "$subject";


        $body ="
        <img src='http://api.renitrust.com/logo/png/Main.png' width='15%' />
        <br /> <br />
        $body<br />
        <br />
        <br />
        Sheda House Orogun Ibadan.<br />

        ";
        // Set HTML 
        $mail2->isHTML(TRUE);
        $mail2->Body = $body;
        $mail2->AltBody = strip_tags($body);

          if($mail2 -> send()){
            $body = addslashes($body);
$this->recordEmail($email, $subject, $body, $timestamp, 1);
    return $this->returnData(true, 'email sent', null);
          }else{
$body = addslashes($body);
$this->recordEmail($email, $subject, $body, $timestamp, 0);
    return $this->returnData(false, 'email not sent', null);
          }
}




public static function sendEmail_jhghjgj ($email,$subject,$body,$timestamp){

    // create a new object
    $mail = new PHPMailer();

    // configure an SMTP
    $mail->isSMTP();
    $mail->Host = 'business147.web-hosting.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@renitrust.com';
    $mail->Password = 'C^k+xGz^X^II';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('no-reply@renitrust.com', ''.Consts::PlatformName().'');
$dbname = "ReniTrust";
$mail2 = clone $mail;
    $mail2->addAddress($email, $dbname);
   $mail2->addReplyTo(''.Consts::PlatformEmail().'', ''.Consts::PlatformName().'');
    $mail2->Subject = "$subject";


        $body ="
        <img src='http://api.renitrust.com/logo/png/Main.png' width='15%' />
        <br /> <br />
        $body<br />
        <br />
        <br />
        Sheda House Orogun Ibadan.<br />

        ";
        // Set HTML 
        $mail2->isHTML(TRUE);
        $mail2->Body = $body;
        $mail2->AltBody = strip_tags($body);

          if($mail2 -> send()){
            $body = addslashes($body);
self::recordEmail_($email, $subject, $body, $timestamp, 1);
    return self::returnData(true, 'email sent', null);
          }else{
$body = addslashes($body);
self::recordEmail_($email, $subject, $body, $timestamp, 0);
    return self::returnData(false, 'email not sent', null);
          }
}




// send email through reniMail
public function sendEmail_renimailjugygugy ($email = null, $subject = null, $body = null, $timestamp = null, $sender=null)
{

    // code...
    if ($email != null and $subject != null and $body != null and $timestamp != null) {
        // code...
        $Consts = new Consts();
$reniMailOut = json_decode($Consts->getReniMailOut());
$reniTechOut = json_decode(Consts::getReniTechOut());
$renitoken = $reniTechOut->renitoken;

if ($sender == "null") {
    // code...
    $sender = "";
}

$endpoint = "".$reniMailOut->endpoint."/sendMail"."";
        $curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('subject'=> $subject, 'body'=> $body, 'email' => $email, 'sender' => $sender)));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $renitoken"
        ));


$response = curl_exec($curl);

// var_dump($response);
// exit;

curl_close($curl);
$data = json_decode($response);

if (empty($data)) {
    // code...
    return $this->returnData(false, 'Something went wrong..', null);
    exit();
}

if (isset($data->success)) {
    // code...
if ($data->success == true) {
    // code...
    return $this->returnData(true, 'Email sent..', $data);
} else {
    return $this->returnData(false, 'Email not sent!..', $data);
}
} else {
    // return $this->returnData(false, 'Something went wrong!..', $data);
    $this->sendEmail($email,$subject,$body,$timestamp);
}

    } else {
    return $this->returnData(false, 'empty data..', null);
    }
}
// end send email through reniMail



// send email through reniMail
public static function sendEmail_renimail_jfffhjhj ($email = null, $subject = null, $body = null, $timestamp = null, $sender=null)
{

    // code...
    if ($email != null and $subject != null and $body != null and $timestamp != null) {
        // code...
        $Consts = new Consts();
$reniMailOut = json_decode($Consts->getReniMailOut());
$reniTechOut = json_decode(Consts::getReniTechOut());
$renitoken = $reniTechOut->renitoken;

if ($sender == "null") {
    // code...
    $sender = "";
}

$endpoint = "".$reniMailOut->endpoint."/sendMail"."";
        $curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('subject'=> $subject, 'body'=> $body, 'email' => $email, 'sender' => $sender)));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $renitoken"
        ));


$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response);

if (empty($data)) {
    // code...
    return self::returnData(false, 'Something went wrong..', null);
    exit();
}

if (isset($data->success)) {
    // code...
if ($data->success == true) {
    // code...
    return self::returnData(true, 'Email sent..', $data);
} else {
    return self::returnData(false, 'Email not sent!..', $data);
}
} else {
    // return $this->returnData(false, 'Something went wrong!..', $data);
    self::sendEmail($email,$subject,$body,$timestamp);
}

    } else {
    return self::returnData(false, 'empty data..', null);
    }
}
// end send email through reniMail



public function recordEmail($mail=null, $subject=null, $body=null, $time=null, $sent=0)
{
    // code...
    try{
  // prepare sql and bind parameters
$sql = "INSERT INTO mail_tb (mail, subject, body, timestamp, sent)
  VALUES (:mail, :subject, :body, :timestamp, :sent)";

  $stmt = db::connect()->prepare($sql);
  $stmt->bindParam(':mail', $mail);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':body', $body);
  $stmt->bindParam(':sent', $sent);
  $stmt->bindParam(':timestamp', $time);

  // $stmt->execute();

  // return "New records created successfully $name";
  if (!$stmt->execute()) {
    // code...
    return $this->returnData(false, 'Could not register this email, please try again', null);
  }else{
return $this->returnData(true, 'Email registered successfuly.', null);
  }
}
catch(PDOException $e) {
    $_SESSION['err'] = $e->getMessage();
  return false;
}

}



public static function recordEmail_($mail=null, $subject=null, $body=null, $time=null, $sent=0)
{
    // code...
    try{
  // prepare sql and bind parameters
$sql = "INSERT INTO mail_tb (mail, subject, body, timestamp, sent)
  VALUES (:mail, :subject, :body, :timestamp, :sent)";

  $stmt = db::connect_()->prepare($sql);
  $stmt->bindParam(':mail', $mail);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':body', $body);
  $stmt->bindParam(':sent', $sent);
  $stmt->bindParam(':timestamp', $time);

  // $stmt->execute();

  // return "New records created successfully $name";
  if (!$stmt->execute()) {
    // code...
    return self::returnData(false, 'Could not register this email, please try again', null);
  }else{
return self::returnData(true, 'Email registered successfuly.', null);
  }
}
catch(PDOException $e) {
    $_SESSION['err'] = $e->getMessage();
  return false;
}

}



public static function outputData ($success=false, $message="Sonething went wrong, please try again..", $data=array(), $exit = false, $httpStatus=200)
{
    // code...
    $output = array(
        'success' => $success,
        'message' => $message,
        'data' => $data
    );
    // echo base64_encode(json_encode($output));
    echo json_encode($output);

    foreach (get_defined_vars() as $var) {
    unset($var);
    }

if ($exit == true) {
    exit();
}
}


# end of custom functions


// check apptoken
public static function verifyAppToken($params)
{
    if ($params==null) {
       return self::cUtils::returnData(false, "No data found", $params, true);
    }

    Consts::loadEnv();

    if ($_ENV['APPTOKEN'] != $params['token']) {
       return self::returnData(false, "NOT Verified", $params, true);
    }

    return self::returnData(true, "Verified", $params, true);
}
// end check apptoken


  public static function returnData ($status=false, $message=null, $data=null, $exit=false)
  {
    // code...
    if ($data == null) {
        // code...
        $data = array();
    }
    $payload = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );

    return json_encode($payload);

    foreach (get_defined_vars() as $var) {
    unset($var);
}

if ($exit==true) {
    exit;
}

  }



public function convertNumberFormatToNumber($number)
{
    // code...
    $parsed = floatval(preg_replace('/[^\d.]/', '', $number));
    return floatval($parsed);
}


public static function convertNumberFormatToNumber_($number)
{
    // code...
    $parsed = floatval(preg_replace('/[^\d.]/', '', $number));
    return floatval($parsed);
}


public function getUserIP()
{
    // if user from the share internet
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    //if user is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //if user is from the remote address
    else{
        return $_SERVER['REMOTE_ADDR'];
    }
}



public function encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $encryptedData = base64_encode($iv . $ciphertext);
    
    if ($encryptedData === false) {
        $error = openssl_error_string();
        error_log($error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        return null;
    }else{
        return $encryptedData;
    }   
}



public static function encrypt_($data, $key) {
    $iv = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $encryptedData = base64_encode($iv . $ciphertext);
    
    if ($encryptedData === false) {
        $error = openssl_error_string();
        error_log($error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        return null;
    }else{
        return $encryptedData;
    }   
}



public function decrypt($encryptedData, $key) {
    $key_ = $this->convertDataTo32Bit($key);
   $data = base64_decode($encryptedData ?? '');
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key_, OPENSSL_RAW_DATA, $iv);
    if ($plaintext === false) {
        $error = openssl_error_string();
        error_log("727 ".$error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        $plaintext = $this->decrypt_128bits($encryptedData, $key);
        return $plaintext;
    }else{
        return $plaintext;
    }
}



public static function decrypt_($encryptedData, $key) {
    $key_ = self::convertDataTo32Bit_($key);
   $data = base64_decode($encryptedData ?? '');
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key_, OPENSSL_RAW_DATA, $iv);
    if ($plaintext === false) {
        $error = openssl_error_string();
        error_log("727 ".$error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        $plaintext = self::decrypt_128bits_($encryptedData, $key);
        return $plaintext;
    }else{
        return $plaintext;
    }
}




public function decrypt_128bits($encryptedData, $key) {
    $key_ = $this->convertDataTo16Bit($key);
   $data = base64_decode($encryptedData);
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $plaintext = openssl_decrypt($ciphertext, 'aes-128-cbc', $key_, OPENSSL_RAW_DATA, $iv);
    if ($plaintext === false) {
        $error = openssl_error_string();
        error_log("747 ".$error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        return false;
    }else{
        return $plaintext;
    }
    
}



public static function decrypt_128bits_($encryptedData, $key) {
    $key_ = self::convertDataTo16Bit_($key);
   $data = base64_decode($encryptedData);
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $plaintext = openssl_decrypt($ciphertext, 'aes-128-cbc', $key_, OPENSSL_RAW_DATA, $iv);
    if ($plaintext === false) {
        $error = openssl_error_string();
        error_log("747 ".$error);
        // Handle the error here (e.g. log it, throw an exception, etc.)
        return false;
    }else{
        return $plaintext;
    }
    
}


public function convertDataTo32Bit ($key){
    $key = str_pad($key, 32, "\0");
    return $key;
}


public static function convertDataTo32Bit_ ($key){
    $key = str_pad($key, 32, "\0");
    return $key;
}

public function convertDataTo32Bit_1 ($key){
    $key = str_pad($key, 32, "abc");
    return $key;
}


public function convertDataTo16Bit ($key){
    $key = str_pad($key, 16, "\0");
    return $key;
}


public static function convertDataTo16Bit_ ($key){
    $key = str_pad($key, 16, "\0");
    return $key;
}


public function getPayload($data){
    $Consts = new Consts();
$key = $Consts->encKey();
$key = $this->convertDataTo32Bit_1($key);

$decryptedData = json_decode($this->decrypt_2($data, $key));
return $decryptedData;
}



public function decrypt_2($data, $secretKey)
{
$decoded_key = hex2bin($secretKey);
$decoded_ciphertext = base64_decode($data);

$iv_size = 16; // AES block size is fixed at 128 bits

$iv = substr($decoded_ciphertext, 0, $iv_size);
$encrypted_data = substr($decoded_ciphertext, $iv_size);

$decrypted_data = openssl_decrypt($encrypted_data, 'AES-256-CBC', $decoded_key, OPENSSL_RAW_DATA, $iv);

return $decrypted_data;
}



// send notifications
public function sendNotification($usertoken=null, $subject=null, $body=null)
{
    
    try {
        if ($usertoken != null and $subject != null and $body != null) {
            // code...
            $time = time();
            $subject = addslashes($subject);
            $body = addslashes($body);
            $sql = "INSERT INTO notifications (usertoken, subject, body, timestamp)
  VALUES (:usertoken, :subject, :body, :timestamp)";
  $stmt = db::connect()->prepare($sql);
  $stmt->bindParam(':usertoken', $usertoken);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':body', $body);
  $stmt->bindParam(':timestamp', $time);
  
  // $stmt->execute();

  // return "New records created successfully $name";
  if (!$stmt->execute()) {
    return $this->returnData(true, 'Notification sent!', null);
  }else{
    return $this->returnData(false, 'Notification not sent!', null);
  }
        }else{
return $this->returnData(false, 'Missing data..', null);
        }
    } catch (Exception $e) {
        
    }
}
// end send notifications



// send notifications
public static function sendNotification_($usertoken=null, $subject=null, $body=null)
{
    
    try {
        if ($usertoken != null and $subject != null and $body != null) {
            // code...
            $time = time();
            $subject = addslashes($subject);
            $body = addslashes($body);
            $sql = "INSERT INTO notifications (usertoken, subject, body, timestamp)
  VALUES (:usertoken, :subject, :body, :timestamp)";
  $stmt = db::connect()->prepare($sql);
  $stmt->bindParam(':usertoken', $usertoken);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':body', $body);
  $stmt->bindParam(':timestamp', $time);
  
  // $stmt->execute();

  // return "New records created successfully $name";
  if (!$stmt->execute()) {
    return self::returnData(true, 'Notification sent!', null);
  }else{
    return self::returnData(false, 'Notification not sent!', null);
  }
        }else{
return self::returnData(false, 'Missing data..', null);
        }
    } catch (Exception $e) {
        
    }
}
// end send notifications


public function CheckReniToken($renitoken = null)
{
    if ($renitoken == null) {
        return $this->returnData(false, 'empty data..', null);
        exit;
    }

    $reniTechOut = json_decode(Consts::getReniTechOut());
    $endpoint = $reniTechOut->endpoint . "/checkReniToken";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_POST, 1);
    // Set the request payload if required
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: Bearer $renitoken"
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response);

    if (isset($data->success)) {
        if ($data->success == true) {
            return $this->returnData(true, 'Verified.', $data);
        } else {
            return $this->returnData(false, 'Not Verified.', $data);
        }
    }
}


public static function CheckReniToken_($renitoken = null)
{
    if ($renitoken == null) {
        return self::returnData(false, 'empty data..', null);
        exit;
    }

    $reniTechOut = json_decode(Consts::getReniTechOut());
    $endpoint = $reniTechOut->endpoint . "/checkReniToken";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_POST, 1);
    // Set the request payload if required
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: Bearer $renitoken"
    ]);

    $response = curl_exec($curl);

if (curl_errno($curl)) {
    self::systemErrorReporter(array('location'=>"Bank Name resolve - nameEnquiry funtion", 'message'=>curl_error($curl), 'type'=>"API call - curl - ".$url."", 'time'=>time()));
     return self::returnData(false, 'Error connecting.', curl_error($curl));
    exit;
}

    curl_close($curl);

    $data = json_decode($response);

    if (isset($data->success)) {
        if ($data->success == true) {
            return self::returnData(true, 'Verified.', $data);
        } else {
            return self::returnData(false, 'Not Verified.', $data);
        }
    } else {
        return self::returnData(false, 'Not Verified!.', $response);
        exit;
    }
}




// total unread notifications
public function totalUnreadNotes_old($usertoken)
{
    // code...
        try {
        if ($usertoken != null) {
            // code...
        $sql = "SELECT * FROM notifications where (usertoken = '$usertoken' or usertoken = '0') and notice = 1 order by timestamp";
                $stmt = $this->db->connect()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(true, 'Notes', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

return $this->returnData(true, 'Notifications..', $stmt->rowCount());
    }else{
        return $this->returnData(false, 'You have no notifications at the moment', null);
    }
    }
}
}else{
    return $this->returnData(false, 'Unknown user..', null);
}
    } catch (Exception $e) {
        
    }
}
// end total unread notifications



// totl unread notifications
public function totalUnreadNotes($usertoken)
{
    try {
        $sql = "SELECT * FROM notifications WHERE (usertoken = :usertoken1 OR usertoken = '0') AND notice = 1 ORDER BY timestamp";
        $stmt = db::connect()->prepare($sql);
        $stmt->bindParam(':usertoken1', $usertoken);

        if (!$stmt->execute()) {
            throw new Exception("Something went wrong..Utils-notifications-1150");
        }

        if ($stmt->rowCount() == 0) {
            return $this->returnData(true, 'Notes', $stmt->rowCount());
        } else {
            if ($records = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                return $this->returnData(true, 'Notifications..', $stmt->rowCount());
            } else {
                return $this->returnData(false, 'You have no notifications at the moment', null);
            }
        }
    } catch (Exception $e) {
        // Handle the exception here
        return $this->returnData(false, 'Exception occurred: ' . $e->getMessage(), $e);
    }
}

// end total unread notifications



public static function handleErrorResponse($message, $data=null) {
    echo self::outputData_(false, $message, $data);
    exit();
}


public static function handleResponse($message, $data=null) {
    echo self::outputData_(true, $message, $data);
    exit();
}



public static function fetchAllTrx ()
{
    try {
            $sql = "SELECT * FROM bank_trx_records order by timestamp DESC";
                $stmt = db::connect_()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(false, 'No results', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

        $post_data = array();

foreach ($records as $key => $value) {
    // code...

    $datan = array(
        'id' => $value['id'],
        'usertoken' => $value['usertoken'],
        'account_number' => $value['account_number'],
        'recipient_account' => $value['recipient_account'],
        'amount' => $value['amount'],
        'reference_number' => $value['reference_number'],
        'timestamp' => $value['timestamp'],
        'receivername' => $value['receivername'],
        'bankcode' => $value['bankcode'],
        'narration' => $value['narration'],
        'title' => $value['title']
    );

    array_push($post_data, $datan);
}

return self::returnData(true, 'Trx..', $post_data);
    }else{
        return self::returnData(false, 'You have no transaction at the moment', null);
    }
    }
}
    } catch (Exception $e) {
        $_SESSION['err'] = $e->getMessage();
        return false;
    }
}





public static function fetchAllEscrow ()
{
    // code...
    try {
            $sql = "SELECT * FROM escrow order by timestamp DESC";
                $stmt = db::connect_()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(false, 'No results', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

        $post_data = array();

foreach ($records as $key => $value) {
    // code...

    $datan = array(
        'id' => $value['id'],
        'usertoken' => $value['usertoken'],
        's_usertoken' => $value['s_usertoken'],
        's_mail' => $value['s_mail'],
        's_phone' => $value['s_phone'],
        'b_usertoken' => $value['b_usertoken'],
        'b_mail' => $value['b_mail'],
        'b_phone' => $value['b_phone'],
        'title' => $value['title'],
        'description' => $value['description'],
        'amount' => $value['amount'],
        'token' => $value['token']
    );

    array_push($post_data, $datan);
}

return self::returnData(true, 'Escrow list..', $post_data);
    }else{
        return self::returnData(false, 'You have no Escrow list at the moment', null);
    }
    }
}
    } catch (Exception $e) {
        
    }
}





public static function fetchAllDisputes ()
{
    // code...
    try {
            $sql = "SELECT * FROM disputes order by timestamp DESC";
                $stmt = db::connect_()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(false, 'No results', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

        $post_data = array();

foreach ($records as $key => $value) {
    // code...

    $datan = array(
        'id' => $value['id'],
        'token' => $value['token'],
        'usertoken' => $value['usertoken'],
        's_usertoken' => $value['s_usertoken'],
        'b_usertoken' => $value['b_usertoken'],
        'reason' => $value['reason'],
        'resolved' => $value['resolved'],
        'refunded' => $value['refunded'],
        'timestamp' => $value['timestamp'],
        'ended' => $value['ended'],
        'escrowtoken' => $value['escrowtoken'],

    );

    array_push($post_data, $datan);
}

return self::returnData(true, 'Escrow list..', $post_data);
    }else{
        return self::returnData(false, 'You have no Escrow list at the moment', null);
    }
    }
}
    } catch (Exception $e) {
        
    }
}





public static function fetchElectricityTrx ()
{
    // code...
    try {
            $sql = "SELECT * FROM bills_electricity order by time DESC";
                $stmt = db::connect_()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(false, 'No results', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

        $post_data = array();

foreach ($records as $key => $value) {
    // code...

    $datan = array(
        'id' => $value['id'],
        'usertoken' => $value['usertoken'],
        'reference' => $value['reference'],
        'type' => $value['type'],
        'disco' => $value['disco'],
        'account_number' => $value['account_number'],
        'phone' => $value['phone'],
        'amount' => $value['amount'],
        'token' => $value['token'],
        'status' => $value['status']
    );

    array_push($post_data, $datan);
}

return self::returnData(true, 'Escrow list..', $post_data);
    }else{
        return self::returnData(false, 'You have no Escrow list at the moment', null);
    }
    }
}
    } catch (Exception $e) {
        
    }
}



// make api calls
//  0 . headers
//  1. payload
// 2. url
// 3. method
public static function apiCall(...$arg)
{
    
    if (sizeof($arg) < 4) {
        return self::returnData(false, "No data found - ".sizeof($arg)."", $arg, true);
    }

    if (empty($arg[1]) or empty($arg[2])) {
        return self::returnData(false, "Missing data", $arg, true);
    }

    if (!isset($arg[3])) {
        $method = "GET";
    } else {
        $method = $arg[3];
    }

    if (empty($arg[0])) {
      $headers = array();
    } else {
        $headers = $arg[0];
    }

    // return self::returnData(false, "debugging..s", $arg, true);

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $arg[2],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => $method,
  CURLOPT_POSTFIELDS => $arg[1],
  CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);

if (curl_errno($curl)) {

     return self::returnData(false, 'Api call NOT successful_ - '.curl_error($curl).' - '.curl_errno($curl).'', $response);
    exit;
}

$response = json_decode($response);

if (!isset($response)) {
    return self::returnData(false, 'Api call NOT successful - '.curl_error($curl).' - '.curl_errno($curl).'', $response);
    exit;
}

if (empty($response)) {
    return self::returnData(false, 'Api call NOT successful 1 - '.curl_error($curl).' - '.curl_errno($curl).'', $response);
    exit;
}

if ($response == null) {
     return self::returnData(false, 'Api call NOT successful 2 - '.curl_error($curl).' - '.curl_errno($curl).'', $response);
    exit;
}

if ($response == false) {
     return self::returnData(false, 'Api call NOT successful 3 - '.curl_error($curl).' - '.curl_errno($curl).'', $response);
    exit;
}

return self::returnData(true, 'Api call successful!.', $response);

curl_close($curl);
exit;
}
// end make api calls




// fetch countries
public static function fetchCountries()
{
    // code...
    try {
            $sql = "SELECT * FROM countries";
                $stmt = db::connect_()->prepare($sql);
                if (!$stmt->execute()) {
                    $stmt = null;
                  throw new Exception("Something went wrong..Utils-notifications-797");
                }else{
if($stmt->rowCount() == 0){
            return $this->returnData(false, 'No results', $stmt->rowCount());
    // throw new Exception("Something went wrong..Users-userData-51");
        }else{
     if($records = $stmt->fetchAll(PDO::FETCH_ASSOC)){

        $post_data = array();

foreach ($records as $key => $value) {
    // code...

    $datan = array(
        'id' => $value['id'],
        'name' => $value['name'],
        'phoneCountryCode' => $value['phoneCode'],
    );

    array_push($post_data, $datan);
}

return self::returnData(true, 'Countries list..', $post_data);
    }else{
        return self::returnData(false, 'You have no Countries list at the moment', null);
    }
    }
}
    } catch (Exception $e) {
        
    }
}
// end fetch countries



// encrypt data 
public static function encryptData($data=null)
{
    if (empty($data)) {
       return self::returnData(false, "Data must be set..", $data);
       exit;
    }

    $key = Consts::encKey_();
    $key = self::convertDataTo32Bit_($key);
    $enc_data = self::encrypt_($data, $key);

    return self::returnData(true, "encryption done", $enc_data);
exit;
}
// end encrypt data




// decrypt data 
public static function decryptData($data=null)
{
    if (empty($data)) {
       return self::returnData(false, "Data must be set..", $data);
       exit;
    }

    $key = Consts::encKey_();
    $key = self::convertDataTo32Bit_($key);
    $enc_data = self::decrypt_($data, $key);

    return self::returnData(true, "encryption done", $enc_data);
exit;
}
// end decrypt data



// get datetime data
public static function dateTime()
{
    $data = array(
        'timestamp' => time(),
        'day' => date("d", time()),
        'month' => date("F", time()),
        'year' => date("Y", time()),
        'fullDate' => date("d-F-Y", time()),
    );

    return self::returnData(true, "Date time..", $data);
}
// end get datetime data


// verify payload
 public static function validatePayload(array $requiredKeys, $data, array $optionalKey = [])
    {
        $validKeys = array_merge($requiredKeys, $optionalKey);

        $invalidKeys = array_diff(array_keys($data), $validKeys);

        if (!empty($invalidKeys)) {

            foreach ($invalidKeys as $key) {
                $errors[] = "$key is not a valid input field";
            }
        }


        foreach ($requiredKeys as $key) {
            if (empty($data[$key])) {
                $errors[] = ucfirst($key) . ' is required';
            }
        }

        if (!empty($errors)) {
            // code...
            self::outputData(false, "Payload Error", $errors, 400, true);
        }
    }
// end verify payload


// convert array to Object
   public static function arrayToObject($data)
    {
        return json_decode(
            json_encode($data)
        );
    }
// end convert array to Object



// object to array
    public static function objectToArray($data)
    {
        return json_decode(
            json_encode($data),
            true
        );
    }
    // end object to array


    // validate email
public static function validateEmail($email=null)
{
    if ($email==null) {
        return cUtils::returnData(false, "Email data not found", $email, true);
    }

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    list($user, $domain) = explode('@', $email);
    if (checkdnsrr($domain, "MX")) {
        // echo "The email address is valid and the domain has an MX record.";
        return cUtils::returnData(true, "The email address is valid and the domain has an MX record.", $email, true);
    } else {
        // echo "The email address is valid, but the domain does not have an MX record.";
        return cUtils::returnData(false, "The email address is valid, but the domain does not have an MX record.", $email, true);
    }
} else {
    echo "The email address is not valid.";
    return cUtils::returnData(true, "The email address is not valid.", $email, true);
}
}
    // end validate email


// send email
public static function sendEmail($params=null)
{

    if ($params==null) {
        return self::returnData(false, "No data found", $params, true);
    }

    if (empty($params['subject']) or empty($params['body']) or empty($params['email'])) {
        return self::returnData(false, "Missing data", $params, true);
    }

    $reni_key = $_ENV['reni_key'];
    $reni_endpoint = $_ENV['reni_endpoint'];

    $url = $reni_endpoint."/reni-mail/v1/sendSingleMail";
    $headers = array( 'Content-Type: application/json',
        "Authorization: Bearer $reni_key");

    $payload = json_encode(array(
        "email" => $params['email'],
        "body" => $params['body'],
        "subject" => $params['subject']
    ));

    $call = json_decode(self::apiCall($headers, $payload, $url, "POST"));

    if ($call->status == false) {
        // return self::returnData(false, "still debugging", $url, true);
        return self::returnData(false, $call->message, $call, true);
    }

    return self::returnData(true, $call->message, $call->data, true);
}
// end send email



// time data
public static function timeData(...$arg)
{
// Sample timestamp

if (count($arg) < 1) {
    $timestamp = time();
} else {
    $timestamp = $arg[0];
}

// Get date and time information
$date_info = getdate($timestamp);

$data = array(
    "day" => $date_info['mday'],
    "month" => $date_info['mon'],
    "year" => $date_info['year'],
    "hour" => $date_info['hours'],
    "minute" => $date_info['minutes'],
    "second" => $date_info['seconds'],
    "timestamp" => $timestamp
);

return $data;

}
// end time data


// logg errors
public static function log_errors (...$arg)
{
    error_log($error_message, 3, "../../err/error.log");
}
// end logg errors







// API Calls
//  0 . headers
//  1. payload
// 2. url
// 3. method

// array(
//     'Content-Type: application/json',
//     'Authorization: Bearer reni_test_DJiC55T0OEJsJZPS4L4PSK'
//   ),

public static function apiCall_(...$arg)
{
    try {
        
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $arg[2],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => $arg[3],
  CURLOPT_POSTFIELDS => $arg[1],
  CURLOPT_HTTPHEADER => $arg[0]
));

$response = json_decode(curl_exec($curl));

 if (curl_errno($curl)) {
        $error_message = curl_error($curl);
        echo "cURL error: " . $error_message;
        exit;
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_code !== 200) {
        echo "HTTP error: " . $http_code;
        exit;
    }

curl_close($curl);
// echo $response;exit;

return self::returnData(true, "API Call", $response, true);

    } catch (Exception $e) {
        
    }
}
// end API Calls


// get notifications
// 0. usertoken
public static function getNotifications(...$arg)
{
    try {
        if (count($arg) < 1) {
            self::returnData(false, "Missing data", $arg, true);
        }

        $get = json_decode(mUtils::getNotifications($arg[0]));

        echo json_encode($get);exit;
        if ($get->status == false) {
            self::returnData(false, $get->message, $get->data, true);
        }

        self::returnData(true, $get->message, $get->data, true);

    } catch (Exception $e) {
        
    }
}
// end get notifications



// read notifications
// 0. usertoken
// 1. noteID
public static function readNotifications(...$arg)
{
    try {
        if (count($arg) < 1) {
            self::returnData(false, "Missing data", $arg, true);
        }

        // check if notification is correct and user has authorization to read
        $check = json_decode(mUtils::verifyNote($arg[0], $arg[1]));
        if ($check->status == false) {
            self::returnData(false, "Invalid Notification..", null, true);
        }
        // end

        $read = json_decode(mUtils::readNotifications($arg[0], $arg[1]));
        if ($read->status == false) {
            self::returnData(false, $read->message, $read->data, true);
        }

        self::returnData(true, $read->message, $read->data, true);

    } catch (Exception $e) {
        
    }
}
// end read notifications



// get chat notifications
// 0. usertoken
public static function getChatNotifications(...$arg)
{
    try {
        if (count($arg) < 1) {
            self::returnData(false, "Missing data", $arg, true);
        }

        $get = json_decode(mUtils::getChatNotifications($arg[0]));
        if ($get->status == false) {
            self::returnData(false, $get->message, $get->data, true);
        }

        self::returnData(true, $get->message, $get->data, true);

    } catch (Exception $e) {
        
    }
}
// end get notifications

//get request payload
 public static function getRequestPayload() {
       
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            self::outputData(false, "Invalid JSON payload.", null, true);
        }

        return $data;
    }

// end payload request


}
// end of class