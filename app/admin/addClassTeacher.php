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
$staff->adminUser($userid,$clientid);
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$class = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_STRING);
$staff_id = filter_input(INPUT_POST, "staff", FILTER_SANITIZE_NUMBER_INT);
//$studentid = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_NUMBER_INT);

$client->addClassTeacher($staff_id,$class,$clientid,$userid,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}