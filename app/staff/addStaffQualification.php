<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$instname = filter_input(INPUT_POST, "instname", FILTER_SANITIZE_STRING);
$cert = filter_input(INPUT_POST, "certname", FILTER_SANITIZE_STRING);
$yrgrad = filter_input(INPUT_POST, "yrgrad", FILTER_SANITIZE_STRING);

$student->staffQualification($instname,$cert,$yrgrad,$userid,$clientid);
    
}
else
{
    echo "Please submit a record";
}