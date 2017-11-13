<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$staff = new staff($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$roleid = $_SESSION['user_info'][2];
$staff->adminUser($roleid,$clientid);
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