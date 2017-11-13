<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\signUp;
use ScoreSheet\staff;
// $base = new base();
// $base->Test();
$dbConnection = new dbConnection();
$login = new signUp($dbConnection);
$staff = new staff($dbConnection);
// $clientid = $_SESSION['user_info'][4];
// //$newStaff = new student();
// $userid = $_SESSION['user_info'][0];
// $myroleid = $_SESSION['user_info'][2];
// $staff->clientUser($myroleid,$clientid);

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$login->setMail($email);
$email = $login->getMail();

$login->setPassword($password);
$password = $login->getPassword();

//$em = 'demo@gmail.com';
//$pass = 'demo_2017';

$login->user_login($email,$password);  
}
else
{
    echo "Please submit a record";
}