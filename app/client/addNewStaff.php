<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);


$client->setUserName($username);
$user = $client->getUserName();

$client->setPassword($pass);
$pass = $client->getPassword();

$client->setRole($role);
$role = $client->getRole();
$client->setEmail($email);
$email = $client->getEmail();

$client->newStaff($email,$username,$pass,$role,$clientid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}