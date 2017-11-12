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
$staff->clientUser($userid,$clientid);
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$prefix = filter_input(INPUT_POST, "prefix", FILTER_SANITIZE_STRING);
//$seperator = filter_input(INPUT_POST, "seperator", FILTER_SANITIZE_STRING);

$student->setSurname($prefix);
$prefix = $student->getSurname();


$student->addPrefixSettings($prefix,$clientid,$userid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}