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
$student_id = filter_input(INPUT_POST, "studid", FILTER_SANITIZE_STRING);
$adm_no_id = filter_input(INPUT_POST, "admno", FILTER_SANITIZE_STRING);


// $client->setUserName($username);
// $user = $client->getUserName();

// $client->setPassword($pass);
// $pass = $client->getPassword();

// $client->setRole($role);
// $role = $client->getRole();


$student->assignNewNumber($student_id,$adm_no_id,$clientid);
    
}
else
{
    echo "Please submit a record";
}